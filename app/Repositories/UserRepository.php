<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Traits\BaseRepository;

class UserRepository
{
    use BaseRepository;

    /**
     * @var User
     */
    protected $model;
    protected $baseUrl;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
        $this->baseUrl = 'users';
    }
}
