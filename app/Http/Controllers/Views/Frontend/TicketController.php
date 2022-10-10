<?php

namespace App\Http\Controllers\Views\Frontend;


use Auth;
use Validator;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TicketRepository;
use App\Repositories\ProjectRepository;
use App\Http\Resources\Ticket as TicketResource;
use App\Http\Resources\TicketCollectiion as TicketCollectiionResource;

class TicketController extends Controller
{

    /**
     * @var TicketRepository $ticketRepository
     */
    protected $ticketRepository;
    protected $projectRepository;

    /**
     * TicketController constructor.
     *
     * @param TicketRepository $ticketRepository
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        $organization = session('organization');
        $users = $organization->users()->whereStatus('active')->get();
        $ticketCategories = $organization->ticketCategories;
        $projects = $organization->projects;

        return view("frontend.tickets.index", compact('users', 'ticketCategories', 'projects'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $tickets = $this->ticketRepository->where('is_open', true)->all();
        return  new TicketCollectiionResource($tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  ProjectRepository  $projectRepository
     * @return \Illuminate\Http\Response
     */
    public function create($code,ProjectRepository $projectRepository)
    {
        $project  = $projectRepository->getByCode($code);
        $members  = session('organization')->users()->whereStatus('active')->orderBy('firstname')->get();
        $statuses = session('organization')->ticketCategories;
        $tickets = $project->tickets;

        return view("frontend.tickets.create", compact('project', 'members', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $this->validator($input)->validate();
        try {
            $saved = $this->ticketRepository->store($input);
            if($saved && isset($saved->id)){
                return response()->json(['id'=>$saved->id],201);
            }else{
                return response()->json(['message'=>'error occurred while creating of a ticket'],400);
            }
            //dd($saved);
        } catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($number, ProjectRepository $projectRepository)
    {
        $ticket = $this->ticketRepository
            ->with('project')
            ->with('parent')
            ->with('category')
            ->with('children')
            ->with('files')
            ->findByField('number',$number)->first();

        if (!$ticket) return abort(404);

        return view("frontend.tickets.show", compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  ProjectRepository  $projectRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id, ProjectRepository $projectRepository)
    {
        // On a ps besoin de ca ici. jsute dans la page qui listepluisuers tickets
        $ticket = $this->ticketRepository->findByField('number',$id)
            ->first();
        $ticket->files;
        $statuses = session('organization')->ticketCategories;
        // $projects = ((Organization)(session('organization')))->projects;
        $projects = Organization::where('id',  session('organization')->id)->first()->projects;

        $members  = session('organization')->users()->whereStatus('active')->orderBy('firstname')->get();

        if( is_null($ticket) ) {
            return abort(404);
        }

        $index = 0;

        foreach ($ticket->project->tickets as $item) {
            if ($ticket->id == $item->id) {
                unset($ticket->project->tickets[$index]);
            }
            $index++;
        }

        return view("frontend.tickets.edit", [
            "ticket" => $ticket,
            "tickets" => $ticket->project->tickets,
            "members" => $members,
            'statuses' => $statuses,
            'projects' => $projects
        ]);
    }


    /**
     * Toggle close/open ticket
     * @param  [type] $number [description]
     * @return [type]         [description]
     */
    public function close(Request $request,$number)
    {
        $action ='';
        $ticket = $this->ticketRepository->findByField('number', $number)->first();

        if( is_null($ticket) ) {
            return abort(404);
        }

        if ($ticket->is_open) {
            $action='closed';
        }else{
            $action='opened';
        }
        $ticket->toggleOpen();
        $ticket->save();
        $ticket->createdBy
                ->sendTicketOpenedNotification($request->user(),$ticket,$action);
        if ($ticket->created_by!=$ticket->assignee_id) {
            $ticket->assignee
                    ->sendTicketOpenedNotification($request->user(),$ticket,$action);
         }

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $this->validator($input)->validate();
        try {
            $ticket = $this->ticketRepository->getById($id);
            $updated = $this->ticketRepository->update($ticket->id,$input);
            if($updated && isset($updated->id)){
                return response()->json(['id'=>$updated->id],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = $this->ticketRepository->delete($id);
            if($delete){
                return response()->json(['message'=>'the ticket has been deleted'],200);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'status' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'text|max:255',
            'priority' => 'in:low,medium,high,critical',
            'complexity' => 'in:low,medium,high,critical',
            'project_id' => 'integer',
            'created_by' => 'integer',
            'parent_id' => 'integer',
            'assignee_id' => 'integer',
            'number' => 'required|integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'estimate' => 'string|max:255'
        ]);
    }
}
