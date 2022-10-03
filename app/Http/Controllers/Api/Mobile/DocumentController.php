<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Repositories\User as UserRepo;
use App\Http\Controllers\Controller;
use App\Repositories\DocRepository;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $repository;

    public function __construct (DocRepository $repository) 
    {
        $this->repository = $repository;
    }

    /**
     * Get user documents 
     * 
     * @return Json 
     */
    public function getUserDocuments (Request $request) 
    {
        try 
        {
            $user = $request->user();
            $role = $user->role;

            $data['userDocuments'] = $user->documents;
            $data['roleDocuments'] = $role->documents;

            foreach ($data['userDocuments'] as $doc) {
                $doc->link = str_contains($doc->pivot->link, 'http') 
                    ? $doc->pivot->link
                    : \Storage::url($doc->pivot->link);
            }

            return response()->json($data);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Upload document
     */
    public function uploadDocument (Request $request)
    {
        try 
        {
            $user = $request->user();

            if (!$user) {
                info('uploadDocument => User not found');
                return response()->json('User not found', 404);
            }

            info ('User ' . $user->code . ' uploading file...');

            if (is_string($request->file) && substr($request->file, 0, 5) === "data:") {
                info('Uploading base64 image.....');
                $res = $this->repository->uploadBase64($request->file);
            } else {
                info('Uploading file image.....');
                $res = $this->repository->uploadFile($request->file('file'));
            }

            return response()->json($res);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Assign document to a user 
     * 
     * @return Json
     */
    public function assignUser (Request $request)
    {
        try 
        {
            $user = $request->user();
            $document = $this->repository->findModelByCode($request->documentCode);

            $user->documents()->attach($document->id, [
                'status' => 'pending',
                'link'   => str_replace(['"', "\\"], "", $request->filePath)
            ]);

            return response()->json($document);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
