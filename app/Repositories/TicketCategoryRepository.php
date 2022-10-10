<?php

namespace App\Repositories;

use App\Models\TicketCategory;
use App\Repositories\Traits\BaseRepository;

class TicketCategoryRepository
{
    use BaseRepository;

    /**
     * @var TicketCategory
     */
    protected $model;
    protected $baseUrl;

    /**
     * TicketCategoryRepository constructor.
     *
     * @param TicketCategory $ticketCategory
     */
    public function __construct(TicketCategory $ticketCategory)
    {
        $this->model = $ticketCategory;
        $this->baseUrl = 'ticketCategories';
    }

    public function getByOrganization($id)
    {
        return $this->model->where('organization_id', $id)
        ->orderBy('id')->get();
    }
}
