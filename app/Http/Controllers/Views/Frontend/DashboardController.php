<?php

namespace App\Http\Controllers\Views\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\OrganizationRepository;

class DashboardController extends Controller
{
	 /**
     * @var OrganizationRepository $organizationRepository
     */
    protected $organizationRepository;

	 /**
     * @var ProjectRepository $projectRepository
     */
    protected $projectRepository;

    /**
     * @var TicketRepository $ticketRepository
     */
    protected $ticketRepository;
    /**
     * DashboardController constructor.
     *
     * @param ProjectRepository $projectRepository
     */
    public function __construct(OrganizationRepository $organizationRepository,ProjectRepository $projectRepository,TicketRepository $ticketRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {

        $statistics=[];
        $organization  = session('organization');
    	$project = $this->projectRepository->projectStatisticsByOrganization($organization);
    	$ticket = $this->ticketRepository->ticketStatisticsByOrganization($organization);
        $member = $this->organizationRepository->memberStatisticsByOrganization($organization);
    	$statistics['project']=$project;
    	$statistics['ticket']=$ticket;
        $statistics['member']=$member;

        return view('frontend.dashboard.home', compact('statistics'));
    }
}
