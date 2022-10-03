<?php

namespace App\Http\Controllers\Api\V1;

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
            $collection = $repo->filter($request->all());
            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get withdrawal
     * 
     * @return App\Models\Withdrawal
     */
    public function getWithdrawal (WidthdrawalRepository $repo, string $code)
    {
        try 
        {
            $model = $repo->getModel($code);
            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * 
     */
    public function updateWithdrawal (WidthdrawalRepository $repo, Request $request, string $code)
    {
        try 
        {
            $model = $repo->getModel($code);
            $model = $repo->updateWithdrawal($model, $request->status);
            $model->load(['user', 'audits']);

            return response()->json($model);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
