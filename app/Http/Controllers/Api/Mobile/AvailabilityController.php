<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Repositories\AvailabilityRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function update (AvailabilityRepository $repo, Request $request) 
    {
        try 
        {
            $user = $request->user();
            $dates = explode(',', $request->dates);

            $repo->updateAvailabilities($user, $dates);
            $availabilies = $repo->getUserAvailabilities($user->code);
            
            return response()->json($availabilies);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    public function show (AvailabilityRepository $repo, string $code) 
    {
        try 
        {
            $availabilies = $repo->getUserAvailabilities($code);
            
            return response()->json($availabilies);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
