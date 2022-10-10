<?php

namespace App\Repositories;

use App\Models\ProjectCategory;
use App\Repositories\Traits\BaseRepository;

class ProjectCategoryRepository
{
    use BaseRepository;

    /**
     * @var ProjectCategory
     */
    protected $model;
    protected $baseUrl;

    /**
     * ProjectCategoryRepository constructor.
     *
     * @param ProjectCategory $projectCategory
     */
    public function __construct(ProjectCategory $projectCategory)
    {
        $this->model = $projectCategory;
        $this->baseUrl = 'projectCategories';
    }

    public function getByOrganization($id)
    {
        return $this->model->where('organization_id', $id)
        ->orderBy('name')->get();
    }
}
