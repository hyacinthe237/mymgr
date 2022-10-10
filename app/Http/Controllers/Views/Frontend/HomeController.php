<?php

namespace App\Http\Controllers\Views\Frontend;

use App\Http\Controllers\Controller;
use App\Events\ContactSubmission;
use Illuminate\Http\Request;
use App\Models\Newsletter;

class HomeController extends Controller
{
    public function index ()
    {

        return view('frontend.home.landing');
    }

    // public function index () {
    //     return view('home.index');
    // }


    public function chef ()
    {
        return view('frontend.pages.become-chef');
    }


    public function about ()
    {
        return view('frontend.pages.about');
    }

    public function terms ()
    {
        return view('frontend.pages.terms');
    }

    public function contact ()
    {
        return view('frontend.pages.contact');
    }

    public function privacy ()
    {
        return view('frontend.pages.privacy');
    }


    public function postEmail (Request $request)
    {
        Newsletter::create($request->except('_token'));
        return redirect()->back()->with('message', 'Thanks for leaving your email');
    }


    public function postContact (Request $request)
    {
        event(new ContactSubmission($request->except('_token')));
        return redirect()->back()->with('message', 'Thanks for contacting us');
    }
}
