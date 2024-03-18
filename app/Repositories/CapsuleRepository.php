<?php
namespace App\Repositories;


class CapsuleRepository
{
    public function indexQuery($user, $request)
    {
        // dd($request->all(), 'in repo');
        $capsuleQuery = $user->capsules();

        if ($request->filled('searchQuery')) {
            $searchQuery = $request->input('searchQuery');
            $capsuleQuery->where(function ($query) use ($searchQuery) {
                $query->where('message', 'like', "%$searchQuery%")
                      ->orWhere('openeing_time', 'like', "%$searchQuery%");
            });
        }

        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $capsuleQuery->whereBetween('openeing_time', [$startDate, $endDate]);
        }

        return $capsuleQuery;
    }

    public function create($user, $data)
    {
        return $user->capsules()->create($data);
    }

    public function find($user, $id)
    {
        return $user->capsules()->findOrFail($id);
    }

    public function update($user, $data, $id)
    {
        $capsule = $this->find($user, $id);
        $capsule->update($data);
        return $capsule;
    }

    public function delete($user, $id)
    {
        $capsule = $this->find($user, $id);
        $capsule->delete();
    }
}
