<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DocRepository;
use App\Repositories\User as UserRepo;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Booking as BookingRepo;
use App\Http\Resources\BookingResourceCollection;

class UserController extends Controller
{
    public $userRepo; 


    public function __construct (UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index (Request $request)
    {
        try 
        {
            $users = $this->userRepo->filterUsers($request->all());
            return response()->json($users);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    public function getAdmins (Request $request)
    {
        try 
        {
            $users = $this->userRepo->getAdmins();
            return response()->json($users);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Update a single user 
     */
    public function update (UpdateUserRequest $request, $code)
    {
        try 
        {   
            $model = $this->userRepo->findByCode($code);
            $updated = $this->userRepo->update($model, $request);
            return response()->json($updated);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Get a single user 
     */
    public function show ($code)
    {
        try 
        {   
            $model = $this->userRepo->findByCode($code);
            $model->role;
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get user bookings 
     * 
     * @return BookingResourceCollection 
     */
    public function getBookings (Request $request, BookingRepo $bookingRepo, $code)
    {
        try 
        {   
            $user = $this->userRepo->findByCode($code);
            $request->usertype = $user->usertype;
            $bookings = $bookingRepo->getUserBookings($request, $user->id);

            $collection = new BookingResourceCollection($bookings);
            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get user documents 
     * 
     * @return Collection 
     */
    public function getDocuments ($code)
    {
        try 
        {   
            $user = $this->userRepo->findByCode($code);
            $role = $user->role;

            $data['userDocuments'] = $user->documents;
            $data['roleDocuments'] = $role->documents;

            return response()->json($data);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Update document status 
     * 
     * @return Json
     */
    public function updateDocuments ($userCode, $documentCode)
    {
        try 
        {   
            $user = $this->userRepo->findByCode($userCode);
            if (!$user) abort(404);

            $docRepo = resolve(DocRepository::class);
            $doc = $docRepo->findModelByCode($documentCode);

            $user->documents()->updateExistingPivot($doc->id, request()->only('status'));

            return response()->json($doc);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get newsletter 
     * 
     * @return Json 
     */
    public function getNewsletter (Request $request)
    {
        try 
        {
            $users = $this->userRepo->getNewsletter($request->all());
            return response()->json($users);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
