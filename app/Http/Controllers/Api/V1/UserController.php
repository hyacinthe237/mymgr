<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection as UserCollectionResource;

class UserController extends Controller
{

    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->all();
        return  new UserCollectionResource($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        try {
            $saved = $this->userRepository->store($input);
            if($saved && isset($saved->id)){
                return response()->json(['id'=>$saved->id],201);
            }else{
                return response()->json(['message'=>'error occurred while creating of a user'],400);
            }
        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->getById($id);

        if(is_null($user) ) {
            return abort(404);
        }
        return  new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $input = $request->only(['firstname', 'lastname', 'email', 'phone', 'gender']);

        try
        {
            $user = $this->userRepository->getById($id);
            $updated = $this->userRepository->update($user->id, $input);
            $updated->organizations()->updateExistingPivot(
                request()->organization->id,
                request()->only('position')
            );

            $org = $updated->organizations()->where('organization_id', request()->organization->id)->first();
            $updated->position = $org->pivot->position;

            return response()->json($updated);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * block user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blocked($id)
    {
        try
        {
            $user = $this->userRepository->getById($id);

            if (!$user)
               return response()->json('User not found', 404);

            $user->status = $user->status === 'active' ? 'blocked' : 'active';
            $user->save();

            dd($user->status);

            $str = 'User is ' . $user->status;
            return response()->json($str);
        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * activate user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activated($id)
    {
        try
        {
            $user = $this->userRepository->getById($id);

            if (!$user)
               return response()->json('User not found', 404);

            if ($user->status == 'blocked') {
                $user->status = 'active';
                $user->update();
                return response()->json('User is activated', 200);
            }

        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
          $user = User::findOrFail($id);

          if (!$user)
              return response()->json("Member not found", 404);

          $user->delete();
          return response()->json("Member deleted successfully");
        }catch (\Exception $e) {
            return response()->json(['message' => 'internal server error'], self::HTTP_ERROR);
        }
    }

}
