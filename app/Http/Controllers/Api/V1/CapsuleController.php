<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCapsuleRequest;
use App\Http\Requests\Api\UpdateCapsuleRequest;

use App\Services\CapsuleService;
use Illuminate\Http\Request;

class CapsuleController extends Controller
{
   
    protected $capsuleService;

    public function __construct(CapsuleService $capsuleService)
    {
        $this->capsuleService = $capsuleService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return $this->capsuleService->all($user, $request);
    }

    public function store(StoreCapsuleRequest $request)
    {
        $user = auth()->user();
        return $this->capsuleService->store($user, $request);
    }

    public function view(Request $request, $id)
    {
        $user = auth()->user();
        return $this->capsuleService->view($user, $id);
    }

    public function update(UpdateCapsuleRequest $request, $id)
    {
        $user = auth()->user();
        return $this->capsuleService->update($user, $request, $id);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        return $this->capsuleService->destroy($user, $id);
    }
}
