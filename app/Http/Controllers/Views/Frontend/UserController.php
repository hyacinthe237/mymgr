<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a member projects list
     * @return [list]           [list of project]
     */
    public function myprojects ()
    {
        $user = Auth::user();
        $organization = session('organization');
        $projects = $organization->projects()
            ->with('category', 'owner')
            ->where('owner_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('frontend.users.myprojects', compact('projects'));
    }

    /**
     * Display a member tickets list
     * @return [list]           [list of ticket]
     */
    public function mytickets ()
    {
        $user = Auth::user();
        $organization = session('organization');
        $tickets = $organization->tickets()
            ->with('category', 'assignee', 'project')
            ->where('is_open', true)
            ->where('assignee_id', $user->id)
            ->orderBy('id', 'desc')->get();
        return view('frontend.users.mytickets', compact('tickets'));
    }

    /**
     * Display a member profile
     * @param  Request $request [description]
     * @param  [type]  $code    [description]
     * @return [type]           [description]
     */
    public function show (Request $request, $code)
    {
        $userconnect = Auth::user();
        $organization = session('organization');
        $member = session('organization')->users()->whereCode($code)->first();
        $member->position = $member->pivot->position;

        return view('frontend.members.show', compact('member', 'userconnect', 'organization'));
    }
}
