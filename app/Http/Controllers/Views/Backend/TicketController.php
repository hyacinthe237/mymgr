<?php

namespace App\Http\Controllers\Views\Backend;

use App\Repositories\TicketRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index ()
    {
        return view('backend.support.tickets');
    }



    public function show (TicketRepository $ticketRepo, $code)
    {
        $ticket = $ticketRepo->findModelByCode($code);
        return view('backend.support.ticket', ['ticket' => $ticket]);
    }
}
