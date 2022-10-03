<?php

namespace App\Http\Controllers\Api\Mobile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    /**
     * Get user tickets 
     * 
     * @return Collection 
     */
    public function index (TicketRepository $repo, Request $request) 
    {
        try 
        {
            $user = $request->user();
            $tickets = $repo->getUserTickets($user->id);

            return response()->json($tickets);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    
    /**
     * Save a new booking 
     * 
     * @return Json 
     */
    public function store (Request $request, TicketRepository $repo)
    {
        try 
        {
            $rules = [
                'title'       => 'required',
                'description' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

            $user = $request->user();
            $ticket = $repo->createTicket($request, $user->id);
            
            return response()->json($ticket);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Get single ticket
     * 
     * @return App\Models\Ticket 
     */
    public function show (TicketRepository $repo, string $code) 
    {
        try 
        {
            $ticket = $repo->getTicket($code);
            return response()->json($ticket);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Update a ticket 
     * 
     * @return Json 
     */
    public function update (Request $request, TicketRepository $repo, string $code)
    {
        try 
        {
            $rules = [
                'title'       => 'required',
                'description' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);

            $ticket = $repo->findModelByCode($code);
            $ticket = $repo->updateTicket($ticket, $request);
            
            return response()->json($ticket);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


}
