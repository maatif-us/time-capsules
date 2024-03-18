<?php
namespace App\Services;

use App\Exceptions\Capsule\CapsuleException;
use App\Exceptions\Capsule\CreateCapsuleException;
use App\Exceptions\Capsule\UpdateCapsuleException;
use App\Exceptions\Capsule\DeleteCapsuleException;
use App\Exceptions\Capsule\NotAccessibleError;
use App\Exceptions\NotFoundException;
use App\Repositories\CapsuleRepository;
use App\Http\Resources\CapsuleResource;
use Illuminate\Support\Facades\DB;

class CapsuleService
{
    protected $capsuleRepository;

    public function __construct(CapsuleRepository $capsuleRepository)
    {
        $this->capsuleRepository = $capsuleRepository;
    }

    public function all($user, $request)
    {
        $perPage = $request->input('perPage', 5);
        $capsuleQuery = $this->capsuleRepository->indexQuery($user, $request);
        $capsules = $capsuleQuery->paginate($perPage);
        
        $paginationData = [
            'count'             => $capsules->count(),
            'total'             => $capsules->total(),
            'currentPage'       => $capsules->currentPage(),
            'lastPage'          => $capsules->lastPage(),
            'firstItem'         => $capsules->firstItem(),
            'lastItem'          => $capsules->lastItem(),
            'perPage'           => $capsules->perPage(),
            'url'               => $capsules->url($capsules->currentPage()),
            'previousPageUrl'   => $capsules->previousPageUrl(),
            'nextPageUrl'       => $capsules->nextPageUrl(),
            'hasMorePages'      => $capsules->hasMorePages(),
        ];

        return CapsuleResource::collection($capsules)->additional(['meta' => ['pagination' => $paginationData]]);
    }

    public function store($user, $request)
    {
        $capsuleData = [
            'message' => $request->input('message'),
            'openeing_time' => $request->input('openeingTime'),
        ];

        DB::beginTransaction();
        try {
            $capsule = $this->capsuleRepository->create($user, $capsuleData);
            DB::commit();
            return CapsuleResource::make($capsule);
        } catch (\Exception $e) {
            DB::rollback();
            throw new CreateCapsuleException($e->getMessage());
        }
    }

    public function view($user, $id)
    {
        $capsule = $this->capsuleRepository->find($user, $id);

        if (!$capsule) throw new NotFoundException('Invalid Capsule.');
        if (now() <= $capsule->openeing_time) throw new NotAccessibleError('You can not access capsule yet.');

        $capsule->opened_by = $user->id;
        $capsule->opened_at = now();
        $capsule->save();
        return CapsuleResource::make($capsule);
    }

    public function update($user, $request, $id)
    {
        $capsuleData = [
            'message' => $request->input('message'),
            'opening_time' => $request->input('openingTime'),
        ];

        DB::beginTransaction();
        
        try {
            $capsule = $this->capsuleRepository->update($user, $capsuleData, $id);
            DB::commit();
            return CapsuleResource::make($capsule);
        } catch (\Exception $e) {
            DB::rollback();
            throw new UpdateCapsuleException($e->getMessage(), $e->getCode());
        }
    }

    public function destroy($user, $id)
    {
        DB::beginTransaction();
        try {
            $this->capsuleRepository->delete($user, $id);
            DB::commit();
            return response()->json(['message' => 'Capsule deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            throw new DeleteCapsuleException($e->getMessage(), $e->getCode());
        }
    }
}
