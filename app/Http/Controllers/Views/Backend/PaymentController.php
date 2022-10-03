<?php

namespace App\Http\Controllers\Views\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\EarningRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index ()
    {
        return view('backend.payments.index');
    }



    public function show (EarningRepository $repo, $code)
    {
        $model = $repo->findModelByCode($code);
        return view('backend.payments.show', ['model' => $model]);
    }
}
