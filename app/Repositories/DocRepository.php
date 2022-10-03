<?php 

namespace App\Repositories;

use Webpatser\Uuid\Uuid;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;


class DocRepository extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Document $model)
    {
        $this->model = $model;
    }

    public function editModel (Document $model, Request $request)
    {
        parent::updateModel($model, $request->only(['name']));
        return $model->fresh();
    }


    /**
     * Upload base64 Image to user profile
     *
     * @param  UserModel $user
     * @param  String    $base64String
     * @return
     */
    public function uploadFile (UploadedFile $file)
    {
        if ($file) {
            $fileName  = Uuid::generate()->string . '.' . $file->guessExtension();

            info ('uploadFile filename ==> ' . $fileName);
            return \Storage::putFileAs('yummooh', $file, $fileName, 'public');
        }

        return null;
    }


    public function uploadBase64 (string $string)
    {
        if ($string) {
            info ('base64 upload is a string');
            $image_parts = explode(";base64,", $string);
            $image_type_aux = explode("image/", $image_parts[0]);
            $fileName  = Uuid::generate()->string . '.' . $image_type_aux[1];

            $image = str_replace('data:image/png;base64,', '', $string);
            $image = str_replace(' ', '+', $string);

            info ('uploadBase64 filename ==> ' . $fileName);
            return \Storage::putFileAs('yummooh', $image, $fileName, 'public');
        }

        return null;
    }
}