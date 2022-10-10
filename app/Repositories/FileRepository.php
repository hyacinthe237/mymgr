<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\Traits\BaseRepository;

class FileRepository
{
    use BaseRepository;

    /**
     * @var File
     */
    protected $model;
    protected $baseUrl;

    /**
     * FileRepository constructor.
     *
     * @param Comment $comment
     */
    public function __construct(File $file)
    {
        $this->model = $file;
        $this->baseUrl = 'files';
    }

}
