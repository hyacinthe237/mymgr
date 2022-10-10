<?php

namespace App\Http\Controllers\Views\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\InvitationRepository;

class TeamController extends Controller
{
	/**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * @var InvitationRepository $invitationRepository
     */
    protected $invitationRepository;

    /**
     * TeamController constructor.
     *
     * @param UserRepository $userRepository
     * @param InvitationRepository $invitationRepository
     */
    public function __construct(UserRepository $userRepository,InvitationRepository $invitationRepository)
    {
        $this->userRepository = $userRepository;
        $this->invitationRepository = $invitationRepository;
    }


    public function index ()
    {
        return view('frontend.members.index');
    }

    /**
     * Accept qn invitation.
     *
     * @param  String  $code
     * @return \Illuminate\Http\Response
     */
    public function invitation($code)
    {
        $invitation  = $this->invitationRepository->getByCode($code);
        if(is_null($invitation) ) {
            return abort(404);
        }

    	$user  = $this->userRepository->findByField('email',$invitation->email);
    	session(['join_organization' => $invitation->organization]);
    	if ($user->isEmpty()) {
    		return redirect()->route('signup');
    	}
    	return redirect()->route('login');


    }
}
