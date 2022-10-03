<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EarningRepository;

class EarningController extends Controller
{
    public function getEarnings (EarningRepository $earningRepo, Request $request) 
    {
        try 
        {
            $user = $request->user();
            $earnings = $earningRepo->getUserEarnings($user->id);
            
            return response()->json($earnings);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
