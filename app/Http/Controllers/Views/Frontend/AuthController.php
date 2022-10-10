<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * AuthController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login () {
        return view('frontend.auth.signin');
    }


    public function signup () {
        return view('frontend.auth.signup');
    }

    public function organization () {
        return view('frontend.auth.organization');
    }

    /**
     * profile
     */
    public function profile ()
    {
        $user = Auth::user();

        $organization = $user->organizations()
        ->where('organizations.id', session('organization')->id)
        ->first();

        $user->position = $organization->pivot->position;

        return view('frontend.members.profile', compact('user'));
    }



    public function signout () {
        if (Auth::check()) {
            session()->flush();
            Auth::logout();
        }
        return redirect()->back();
    }


    /**
     * Sign in
     */
    public function signin (Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'password'  => 'required|min:6',
                'email' 	=> 'required|email'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);
            }

            $email = request('email');
            $password = request('password');
            //$join = request('join');

            if ( Auth::attempt(['email' => $email, 'password' => $password, 'status' => ['pending', 'active']], true) ) {
                $user = Auth::user();
                $this->saveLogin($user, $request);

                return response()->json([
                    'user' => $user,
                    'route' => redirect()->intended('dashboard')->getTargetUrl()
                ]);
            }
            return response()->json('Please check your credentials', self::HTTP_BADREQUEST);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Save login
     * @param  [type] $user    [description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function saveLogin($user, $request)
    {
        $agent = new Agent();

        $user->logins()->create([
            'ip'        => $request->ip(),
            'device'    => $agent->device(),
            'platform'  => $agent->platform(),
            'browser'   => $agent->browser()
        ]);

    }



    /**
     *  Register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(UserRequest $request)
    {
        $input = $request->all();
        try {
            $user = $this->userRepository->store($input);
            if($user && isset($user->id)){
                Auth::login($user);
                return response()->json([
                    'id' => $user->id,
                    'route' => redirect()->intended('dashboard')->getTargetUrl()
                ]);
            }else{
                return response()->json('error occurred while creating of a user', self::HTTP_BADREQUEST);
            }
        } catch (\Exception $e) {
            return response()->json('internal server error',self::HTTP_ERROR);
        }
    }
}
