<?php

namespace App\Http\Controllers\Views\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index ()
    {
        return view('frontend.tasks.index');
    }
}
