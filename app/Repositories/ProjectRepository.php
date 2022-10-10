<?php

namespace App\Repositories;

use DB;
use App\Models\Project;
use Illuminate\Support\Carbon;
use App\Repositories\Traits\BaseRepository;
use App\Repositories\Contracts\RepositoryCriteriaInterface;

class ProjectRepository implements RepositoryCriteriaInterface
{
    use BaseRepository;

    /**
     * @var Project
     */
    protected $model;

    protected $baseUrl;

    protected $fieldSearchable = [
    'owner_id',
    'organization_id'
    ];

    /**
     * ProjectRepository constructor.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->model = $project;
        $this->baseUrl = 'projects';
    }


    public function allByOrganization($organization)
    {
        return $this->model->where('organization_id', $organization->id)->orderBy('title')->get();
    }

    public function projectStatisticsByOrganization($organization)
    {
        //days computing : start of the current month and end of the current month
        $now = Carbon::now();
        $fromDate = $now->today()->startOfMonth(); // or ->format(..)
        $tillDate = $fromDate->copy()->endOfMonth()->toDateString();
        $fromDate = $fromDate->toDateString();

        $lastProjects= $organization->projects()->limit(5)->get();
        $all= $organization->projects()->count();
        $new= $organization->projects()->where('status', 'pending')->count();
        $delayed= $organization->projects()->where('end_date','<',$now)->count();
        $delivred_per_month= $organization->projects()->where('status', 'complete')->count();

        $projects= $organization
            ->projects()
            ->leftJoin('tickets', 'projects.id', '=', 'tickets.project_id')
            ->selectRaw('projects.id,projects.title,SUM(time_to_sec(timediff(tickets.end_date, tickets.start_date)) / 3600) as total_duration')
            ->groupBy('projects.id')
            ->get();

        $projectsByWeek= $organization
            ->projects()
            ->leftJoin('tickets', 'projects.id', '=', 'tickets.project_id')
            ->selectRaw('WEEK(tickets.end_date) as week,SUM(time_to_sec(timediff(tickets.end_date, tickets.start_date)) / 3600) as duration_per_week, projects.id as project_id')
            ->whereBetween( DB::raw('date(tickets.end_date)'), [$fromDate, $tillDate] )
            ->groupBy('projects.id')
            ->groupBy('week')
            ->orderBy('week', 'ASC')
            ->get();

            //set values of weeks in the curent month
            $weeks_array = [];
            $carbon=$now->today()->startOfMonth();
            $month=$carbon->month;
            while (intval($carbon->month) == intval($month)){
                $weeks_array[]= $carbon->weekOfYear;
                $carbon->addWeek();
            }

            $projectRates=[];
            foreach ($projects as $project) {

                $ticketRates= collect([]);

                foreach ($projectsByWeek as  $key => $projetW) {
                    if ($projetW->project_id==$project->id) {
                        if ($project->total_duration==0) {
                             continue;
                        }
                        $projetW->rate=$projetW->duration_per_week/$project->total_duration;
                        $ticketRates->push($projetW);
                    }
                }
                //check the gap between ticketRates and weeks_array and then add default items for weeks that have no month tickets outstanding
                foreach ($weeks_array as  $week) {
                    $exist = array_filter($ticketRates->pluck('week')->all(), function($item) use ($week){
                        return ($item === $week);
                     });

                    if (!$exist) {
                        $obj= new \stdClass();
                        $obj->week=$week;
                        $obj->duration_per_week=0;
                        $obj->rate=0;
                        $obj->project_id=$project->id;
                        $ticketRates->push($obj);
                     }

                }
                //sort ticketRates by week
                $ticketRates = $ticketRates->sortBy('week')->values();
                $project->ticketRates=$ticketRates;
                $projectRates[]=$project;
            }


        $statistics =array( 'lastProjects' =>$lastProjects ,'all' =>$all ,'new' =>$new ,'delayed' =>$delayed ,'delivred_per_month' => $delivred_per_month,'project_rates' =>$projectRates);

        return $statistics;
    }




}
