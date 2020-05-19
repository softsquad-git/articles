<?php

namespace App\Http\Controllers;

use App\Http\Resources\Users\UserResource;
use App\Repositories\LoggedRepository;

class LoggedController extends Controller
{
    /**
     * @var LoggedRepository
     */
    private $loggedRepository;

    /**
     * LoggedController constructor.
     * @param LoggedRepository $loggedRepository
     */
    public function __construct(LoggedRepository $loggedRepository)
    {
        $this->loggedRepository = $loggedRepository;
    }

    /**
     * @return UserResource
     */
    public function user()
    {
        return new UserResource($this->loggedRepository->user());
    }

}
