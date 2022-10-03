<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\User as UserRepo;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NewsletterExport;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index ()
    {
        return view('backend.acl.users');
    }


    public function show (UserRepo $userRepo, string $uuid)
    {
        $user = $userRepo->findByCode($uuid);
        $data['user'] = $user;

        return view('backend.acl.user', $data);
    }


    public function edit (UserRepo $userRepo, string $uuid)
    {
        $user = $userRepo->findByCode($uuid);
        $data['user'] = $user;

        return view('backend.acl.edit', $data);
    }


    public function roles ()
    {
        return view('backend.acl.roles');
    }


    public function newsletter ()
    {
        return view('backend.acl.newsletter');
    }


    public function newsletterDownloadCsv () 
    {
        return Excel::download(new NewsletterExport, 'newsletter.csv');
    }
}
