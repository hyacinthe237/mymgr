<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Repositories\CusineRepository;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function lists (CusineRepository $cuisine) 
    {
        try 
        {
            $lists = [];
            $lists ['cuisines'] = $cuisine->all();

            $lists ['states'] = [
                [ 'short' => 'act', 'name' => 'Australian Capital Territory' ],
                [ 'short' => 'nsw', 'name' => 'New South Wales' ],
                [ 'short' => 'nt', 'name' => 'Northern Territory' ],
                [ 'short' => 'qld', 'name' => 'Queensland' ],
                [ 'short' => 'sa', 'name' => 'South Australia' ],
                [ 'short' => 'ta', 'name' => 'Tasmania' ],
                [ 'short' => 'vic', 'name' => 'Victoria' ],
                [ 'short' => 'wa', 'name' => 'Western Australia' ]
            ];

            return response()->json($lists);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
