<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\Booking as BookingRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index () 
    {
        return view('backend.bookings.bookings');
    }


    public function show (BookingRepository $repo, $code)
    {
        $model = $repo->findModelByCode($code);
        return view('backend.bookings.booking', ['booking' => $model]);
    }
}
