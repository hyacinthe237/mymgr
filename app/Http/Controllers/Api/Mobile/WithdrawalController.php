<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Repositories\WidthdrawalRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function getWithdrawals (WidthdrawalRepository $repo, Request $request) 
    {
        try 
        {
            $user = $request->user();
            $collection = $repo->getUserWithdrawals($user->id);
            
            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Create withdrawal 
     * 
     * @param WithdrawalRepository $repo
     * @param Request $request 
     * 
     * @return App\Models\Withdrawal
     */
    public function storeWithdrawal (WidthdrawalRepository $repo, Request $request)
    {
        try 
        {
            $rules = [
                'amount' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

            $user = $request->user();
            $balance = 9999;
            $amount = $request->amount;

            if ($amount > $balance) {
                return response()->json('The requested amount should not be greater than your current balance', self::HTTP_BADREQUEST);
            }

            $model = $repo->createWithdrawal($user->id, $amount);
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
