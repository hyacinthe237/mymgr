<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\User as UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    /**
     * @var UserRepository $userRepository
     */
    protected $userRepo;

    /**
     * AuthController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }


    /**
     * Show the form for sign in .
     *
     * @return View
     */
    public function login (Request $request)
    {
        return view('backend.auth.login');
    }


     /**
     * Sign out.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout ()
    {
        if (Auth::check()) {
            session()->flush();
            Auth::logout();
        }
        return redirect()->route('admin.login');
    }


    /**
     * Sign in
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doLogin (Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'password'  => 'required|min:6',
                'email'     => 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);
            }

            $email = request('email');
            $password = request('password');

            if ( Auth::attempt(['email' => $email, 'password' => $password, 'status' => ['pending', 'active']], true) ) {
                $user = Auth::user();

                return response()->json([
                    'user' => $user,
                    'route' => redirect()->intended('admin')->getTargetUrl()
                ]);
            }
            return response()->json('Please check your credentials', self::HTTP_BADREQUEST);
        }
        catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
