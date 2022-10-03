<?php

namespace App\Http\Controllers\Api\Mobile;

use Illuminate\Support\Facades\Validator;
use App\Repositories\User as UserRepo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use App\Utilities\StripeService;
use Mail;
use Auth;

class AuthController extends Controller
{
    /**
     * Sign up 
     * 
     * @param Request $request 
     * @param UserRepo $userRepo
     * @return Json 
     */
    public function signup (Request $request, UserRepo $userRepo, StripeService $stripe)
    {
        try 
        {
            $rules = [
                'username'          => 'required|unique:users',
                'firstname'         => 'required',
                'lastname'          => 'required',
                'mobile'            => 'required',
                'email'             => 'required|email|unique:users',
                'password'          => 'required|min:6',
                'password_confirm'  => 'required|same:password',
                'country_id'        => 'required|integer',
                'role_id'           => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

                
            $user  = $userRepo->store($request);
            $stripeCustomerToken = $stripe->createCustomer($user);

            if ($request->stripeCardToken) {
                $stripe->createCard($user, $request->stripeCardToken);
            }

            Mail::to($user->email)->queue(new WelcomeMail($user));

            return response()->json($user, self::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Sign in
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signin (Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'username'  => 'required',
                'password'  => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);
            }

            $username = request('username');
            $password = request('password');

            if ( Auth::attempt(['username' => $username, 'password' => $password, 'status' => ['pending', 'active']], true) ) {
                $user = Auth::user();

                return response()->json($user);
            }
            return response()->json('Please check your credentials', self::HTTP_BADREQUEST);
        }
        catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get authenticated user 
     * 
     * @return Json 
     */
    public function me (Request $request) 
    {
        try 
        {
            return response()->json($request->user(), self::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
