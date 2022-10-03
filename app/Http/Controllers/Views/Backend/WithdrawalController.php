<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\WidthdrawalRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index ()
    {
        return view('backend.withdrawals.index');
    }



    public function show (WidthdrawalRepository $repo, $code)
    {
        $model = $repo->findModelByCode($code);
        return view('backend.withdrawals.show', ['model' => $model]);
    }
}
