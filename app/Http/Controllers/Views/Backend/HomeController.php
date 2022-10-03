<?php

namespace App\Http\Controllers\Views\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\TicketRepository;
use App\Repositories\WidthdrawalRepository;
use App\Repositories\User as UserRepository;
use App\Repositories\Booking as BookingRepository;

class HomeController extends Controller
{


    /**
     * Dasboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard ()
    {
        $userRepo     = resolve(UserRepository::class);
        $ticketRepo   = resolve(TicketRepository::class);
        $bookingRepo  = resolve(BookingRepository::class);
        $withdrawRepo = resolve(WidthdrawalRepository::class);

        $data['pendingUsers']       = $userRepo->countPendingUsers();
        $data['activeBookings']     = $bookingRepo->countPendingBookings();
        $data['pendingTickets']     = $ticketRepo->countPendingTickets();
        $data['pendingWithdrawals'] = $withdrawRepo->countPendingWithdrawals();

        return view('backend.home.dashboard', $data);
    }

    /**
     * List users
     * @return View
     */
    public function users ()
    {
        return view('backend.home.users');
    }

    /**
     * File Manager
     * @return View
     */
    public function files ()
    {
        return view('backend.files.files');
    }
}
