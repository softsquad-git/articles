<?php

namespace App\Http\Controllers;

use App\Http\Resources\Users\UserResource;
use App\Repositories\LoggedRepository;

class LoggedController extends Controller
{
    /**
     * @var $repository
     */
    private $repository;

    public function __construct(LoggedRepository $repository)
    {
        $this->repository = $repository;
    }

    public function user()
    {
        return new UserResource($this->repository->user());
    }

}
