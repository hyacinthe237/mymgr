<?php

namespace App\Http\Controllers\Api\V1;

use Validator;
use Illuminate\Http\Request;
use App\Repositories\FileRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\CommentRequest;
use App\Repositories\TicketRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\OrganizationRepository;
use App\Http\Resources\Ticket as TicketResource;
use App\Http\Resources\TicketCollection as TicketCollectionResource;
use App\Http\Resources\CommentCollection as CommentCollectionResource;

class TicketController extends Controller
{

    /**
     * @var TicketRepository $ticketRepository
     */
    protected $ticketRepository;

    /**
     * @var CommentRepository $commentRepository
     */
    protected $commentRepository;


    /**
     * TicketController constructor.
     *
     * @param TicketRepository $ticketRepository
     */
    public function __construct(TicketRepository $ticketRepository , CommentRepository $commentRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrganizationRepository $orgRepo, Request $request)
    {
        $code = $request->header('organization');
        $organization = $orgRepo->getByCode($code);
        $this->ticketRepository->pushCriteria(app('App\Repositories\Criteria\RequestCriteria'));
        $tickets = $this->ticketRepository->pageByOrganization($organization->id);
        return  new TicketCollectionResource($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        try
        {
            $input = $request->all();
            $organization = request()->organization;

            $input['created_by'] = $request->user()->id;
            $input['number'] = $this->ticketRepository->generateNumber($organization);
            $saved = $this->ticketRepository->store($input);
            return response()->json($saved);

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
    public function show($id)
    {
        $ticket = $this->ticketRepository->getById($id);
        $ticket->files;

        if(is_null($ticket) ) {
            return abort(404);
        }
        return  new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, $id)
    {
        $input = $request->only([
            'assignee_id', 'complexity', 'description', 'end_date', 'estimate',
            'parent_id', 'priority', 'project_id', 'start_date', 'status', 'title',
            'is_open'
        ]);

        try
        {
            $ticket = $this->ticketRepository->getById($id);
            $updated = $this->ticketRepository->update($ticket->id,$input);
            //we check if the status has been updated
            if ($ticket->status!=$updated->status) {
                //send the notification to ticket owner
                $updated->createdBy
                        ->sendTicketStatusNotification($request->user(),$updated);
                if (($updated->created_by!=$updated->assignee_id)&&($updated->assignee_id)) {
                    //send the notification to ticket assignee
                    $updated->assignee
                        ->sendTicketStatusNotification($request->user(),$updated);
                }
            }
            //we check if the ticket has been assigned
            if (($ticket->assignee_id!=$updated->assignee_id)&&($updated->assignee_id)) {
                //send the notification to ticket assignee
                    $updated->assignee
                        ->sendTicketAssignedNotification($request->user(),$updated);
            }

            if ($updated) {
                $updated->assignee;
                $updated->category;
                $updated->project;
                return response()->json($updated);
            }
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * add comment on the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addComment(CommentRequest $request, $id)
    {
        $input = $request->except(['organization']);

        try
        {
            $ticket = $this->ticketRepository->getById($id);
            $input['commentable_id'] = $ticket->id;
            $input['commentable_type'] = get_class($ticket);
            $input['created_by'] = $request->user()->id;
            $comment = $this->commentRepository->store($input);

            if ($comment) {
                $comment->owner;
                return response()->json($comment);
            }
        }catch (\Exception $e) {
            return response()->json(['message'=>'internal server error'],500);
        }
    }

    /**
     * list comment on the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function listComments($id)
    {
        $comments = $this->commentRepository->getByTicketId($id);
        return  new CommentCollectionResource($comments);
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



    public function userTickets (Request $request)
    {
        try
        {
            $user = $request->user();
            $organization = $request->organization ;

            $tickets = $organization->tickets()->where('assignee_id', $user->id)
            ->with('category', 'assignee', 'project')
            ->orderBy('id', 'desc')->get();
            // TODO: Filter tickets by status
            // Only show open (ongoing) tickets
            // Or allow fof filtering

            return response()->json($tickets);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Removing a file by Code
     * @param  [type] $number [description]
     * @return [type]       [description]
     */
    public function removeFile(FileRepository $fileRepo, $number, $file_code)
    {

        $ticket = $this->ticketRepository->getByNumber($number);

        if ( !$ticket )
            return response()->json(['message'=>'Ticket not found'], self::HTTP_NOTFOUND);

        $file = $fileRepo->getByCode($file_code);

        if ( !$file )
            return response()->json(['message'=>'File not found'], 404);

        // Delete file record
        $fileRepo->delete($file->id);

        // Delete file
        Storage::delete($file->link);

        return response()->json(['message'=>'This file as been successfully deleted'], 200);
    }



    /**
     * Get ticket all activity
     * @param  [type] $number [description]
     * @return [type]         [description]
     */
    public function activity ($number)
    {
        try
        {
            $ticket = $this->ticketRepository->getByNumber($number);
            if (!$ticket) return response()->json([]);

            return response()->json($ticket->activity);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

}
