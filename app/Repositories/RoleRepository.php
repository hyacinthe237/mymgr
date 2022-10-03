<?php 

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleRepository
{
    public function getAll (Request $request)
    {
        return Role::orderBy('name')
            ->when($request->has('include'), function ($q) use ($request) {
                return $q->with(explode(',', $request->get('include')));
            })
            ->get();
    }


    public function find ($id)
    {
        return Role::find($id);
    }


    public function addDocument (Role $role, Request $request)
    {
        return $role->documents()->add([
            'name' => $request->name
        ]);
    }
}