<?php

namespace App\Http\Controllers\Views\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index () 
    {
        return view('backend.documents.documents');
    }
}
