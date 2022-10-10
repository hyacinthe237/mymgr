<?php

namespace App\Http\Controllers\Views\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index ()
    {
        return view('frontend.search.index');
    }
}
