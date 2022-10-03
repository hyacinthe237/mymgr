<?php

namespace App\Http\Controllers\Api\V1;

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
     * Update document 
     * 
     * @return App\Models\Document
     */
    public function update (Request $request, $code)
    {
        try 
        {
            $doc = $this->repository->findModelByCode($code);
            $doc = $this->repository->editModel($doc, $request);
            return response()->json($doc);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Delete document 
     * 
     * @return string
     */
    public function delete ($code)
    {
        try 
        {
            $doc = $this->repository->findModelByCode($code);
            $doc = $this->repository->deleteModel($doc);
            return response()->json('Document successfully deleted');
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Upload file
     */
    public function upload (Request $request)
    {
        try 
        {
            $file = $request->file('file')[0];
            $res = $this->repository->uploadFile($file);

            return response()->json($res);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
