<?php

namespace App\Http\Controllers\Views\Frontend;

use Auth;
use App\Utilities\Uuids;
use App\Utilities\Uploads;
use Illuminate\Http\Request;
use App\Models\File as IzyFile;
use App\Http\Controllers\Controller;
use App\Repositories\ProjectRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;

class UploadController extends Controller
{
    use Uuids, Uploads;


    /**
     * Upload file to project
     * @param  ProjectRepository $projectRepo [description]
     * @param  Request           $request     [description]
     * @param  [type]            $code        [description]
     * @return [type]                         [description]
     */
    public function project (ProjectRepository $projectRepo, Request $request, $code)
    {
        try
        {
            $project = $projectRepo->getByCode($code);

            if (!$project) {
                return self::HTTP_BADREQUEST;
            }

            $file = $request->file;
            $directory = self::PROJECT_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $project->files()->create([
                'link' => $file->link,
                'name' => $file->name,
                'code' => $this->generateUuid()
            ]);
        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

    /**
     * Upload photo of profile member
     * @param  UserRepository $userRepo [description]
     * @param  Request           $request     [description]
     * @param  [type]            $code        [description]
     * @return [type]                         [description]
     */
    public function member (UserRepository $userRepo, Request $request, $code)
    {
        try
        {

            $user = $userRepo->getByCode($code);

            if (!$user) {
                return self::HTTP_BADREQUEST;
            }

            $file = $request->file;
            $directory = self::MEMBER_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $user->photo = $file->link;
            $user->update();

             return $user;

        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

    /**
     * Upload file to ticket
     * @param  TicketRepository $ticketRepo [description]
     * @param  Request           $request     [description]
     * @param  [type]            $number        [description]
     * @return [type]                         [description]
     */
    public function ticket (TicketRepository $ticketRepo, Request $request, $id)
    {
        try
        {

            $ticket = $ticketRepo->getById($id);

            if (!$ticket) {
                return self::HTTP_BADREQUEST;
            }

            $file = $request->file;
            $directory = self::TICKET_UPLOADS_DIRECTORY;
            $file = $this->upload($file, $directory);

            $ticket->files()->create([
                'link' => $file->link,
                'name' => $file->name,
                'code' => $this->generateUuid()
            ]);

        }
        catch (Exception $e) {
            return response()->json(['message'=>'internal server error'], self::HTTP_ERROR);
        }
    }

}
