<?php 

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Support\Arr;


class TicketRepository extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }


    /**
     * Create new earning
     * 
     * @return App\Models\Ticket
     */
    public function createTicket ($payload, $userId)
    {
        $number = $this->makeNumber();

        return Ticket::create([
            'user_id'  => $userId,
            'number'   => $number,
            'title'    => $payload->title,
            'description' => $payload->description,
            'status' => 'Pending'
        ]);
    }

    /**
     * Get user tickets 
     * 
     * @return collection 
     */
    public function getUserTickets ($userId)
    {
        return Ticket::with('comments')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(20);
    }


    /**
     * Get single ticket 
     * 
     * @return App\Models\Ticket 
     */
    public function getTicket ($code)
    {
        return Ticket::with('comments', 'comments.user')
            ->where('code', $code)->first();
    }


    /**
     * Update a ticket
     * 
     * @return App\Models\Ticket
     */
    public function updateTicket ($ticket, $payload)
    {
        $ticket->title = $payload->title;
        $ticket->description = $payload->description;
        $ticket->status = $payload->status;
        $ticket->assignee_id = $payload->assignee_id;

        if ($payload->updated_by)
            $ticket->updated_by = $payload->updated_by;
            
        $ticket->save();

        return $ticket;
    }


    /**
     * Filter users 
     * 
     * @return Collection 
     */
    public function filter (array $params) 
    {
        $paginate = Arr::get($params, 'paginate', 10);

        return Ticket::with('client', 'assignee', 'updater')
            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status', '=', $params['status']);
            })
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->where( function ($query) use ($params) {
                    return $query->where('title', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->when(isset($params['assignee']), function ($q) use ($params) {
                return $q->where('assignee_id', '=', $params['rassigneeole']);
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate);
    }



    public function countPendingTickets () 
    {
        return Ticket::where('status', 'pending')->count();
    }


    /**
     * Make booking number 
     */
    private function makeNumber () 
    {
        $number = 1001;
        $latest = Ticket::orderBy('id', 'desc')
            ->first();

        if ($latest)
            return $latest->number += rand(1, 9);
        return $number;
    }
}