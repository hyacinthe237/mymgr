<?php

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Support\Carbon;
use App\Repositories\Traits\BaseRepository;
use App\Repositories\Contracts\RepositoryCriteriaInterface;

class TicketRepository implements RepositoryCriteriaInterface
{
    use BaseRepository;

    /**
     * @var Ticket
     */
    protected $model;
    protected $baseUrl;
    protected $fieldSearchable = ['project_id','status','assignee_id','is_open'];

    /**
     * TicketRepository constructor.
     *
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->model = $ticket;
        $this->baseUrl = 'tickets';
    }


    public function allByProject($project)
    {
        return $this->model->where('project_id', $project->id)
        ->orderBy('id', 'desc')
        ->with('project')
        ->with('parent')
        ->with('children')
        ->with('category')
        ->get();
    }


    public function pageByOrganization($organization_id,$number = 50, $sort = 'desc', $sortColumn = 'ID')
    {
        $this->applyCriteria();

        return $this->model
                ->whereHas('project', function ($query) use ($organization_id) {
                    $query->where('organization_id', $organization_id);
                })
                ->with('category')
                ->orderBy($sortColumn, $sort)
                ->paginate($number);
    }

    public function ticketStatisticsByOrganization($organization)
    {
        $now = Carbon::now();


        $all= $organization->tickets()->count();
        $delayed= $organization->tickets()->where('tickets.end_date','<',$now)->count();
        $open= $organization->tickets()->where('tickets.is_open', 1)->count();
        $close= $organization->tickets()->where('tickets.is_open', 0)->count();
            

        $statistics =array('all' =>$all ,'open' =>$open ,'close' =>$close ,'delayed' =>$delayed);

        return $statistics;
    }

    public function ticketStatisticsByProject($project)
    {

        $open= $project->tickets()->where('tickets.is_open', 0)->count();
        $close= $project->tickets()->where('tickets.is_open', 1)->count();

        $ticketsByUser= $project
            ->tickets()
            ->join('users', 'users.id', '=', 'tickets.assignee_id')
            ->selectRaw('users.id,users.firstname,COUNT(tickets.id) as total')
            ->groupBy('users.id')
            ->get();

            //var_dump($ticketByUser->all()); die();

        $statistics =array('open' =>$open ,'close' =>$close ,'ticketsByUser' =>$ticketsByUser );

        return $statistics;
    }




    public function generateNumber ($organization)
    {
        $number = 100011;
        $latest = $organization->tickets()->orderBy('id', 'desc')->first();
        if ($latest) $number = $latest->number += 1;
        return $number;
    }

}
