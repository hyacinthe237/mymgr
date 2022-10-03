<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\RoleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $roleRepo; 


    public function __construct (RoleRepository $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }


    public function index (Request $request)
    {
        try 
        {
            $roles = $this->roleRepo->getAll($request);
            return response()->json($roles);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    public function addDocument (Request $request)
    {
        try 
        {
            $role = $this->roleRepo->find($request->role_id);
            $role->documents()->create(['name' => $request->name]);

            return response()->json($role->documents);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
