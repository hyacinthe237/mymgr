<?php

namespace App\Repositories;

use App\Models\Organization;
use Illuminate\Support\Carbon;
use App\Repositories\Traits\BaseRepository;

class OrganizationRepository
{
    use BaseRepository;

    /**
     * @var Organization
     */
    protected $model;

    protected $baseUrl;

    protected $defaultPosition = 'Manager';

    protected $fieldSearchable = [
        'name',
        'admin_id'
    ];


    /**
     * OrganizationRepository constructor.
     *
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->model = $organization;
        $this->baseUrl = 'organizations';
    }

     /**
     * @param $input
     * @return Model
     */
    public function store($input)
    {
        $this->save($this->model, $input)
            ->users()
            ->attach($this->model->admin_id, ['position' => $this->defaultPosition]);

        return $this->model;
    }

    public function memberStatisticsByOrganization($organization)
    {
        $now = Carbon::now();
        $lastMembers= $organization->users()->limit(5)->get();
        $all= $organization->users()->count();

        $statistics =array( 'lastMembers' =>$lastMembers ,'all' =>$all);

        return $statistics;
    }

    public function search($key,$organization) {

        
        $projects= $organization
                ->projects()
                ->with('tickets')
                ->with('owner')
                ->with('createdBy')
                ->with('category')
                ->with('organization')
                ->where('projects.title', 'like', '%'.$key.'%')
                ->get();



        $tickets= $organization
                ->tickets()
                ->with('project')
                ->with('createdBy')
                ->with('assignee')
                ->with('parent')
                ->with('children')
                ->with('category')
                ->where('tickets.is_open', 1)
                ->where(function ($query) use ($key)  {
                    $query->where('tickets.title', 'like', '%'.$key.'%')
                       ->orwhere('tickets.number', 'like', '%'.$key.'%');
                })
                ->get();
                

        $users = $organization
                ->users()
                ->with('projects')
                ->with('tickets')
                ->with('organizations')
                ->with('invitations')
                ->where('users.firstname', 'like', '%'.$key.'%')
                ->get();

        $result = array('projects' =>$projects ,'tickets' =>$tickets ,'members' =>$users );

         return $result;


    }
}
