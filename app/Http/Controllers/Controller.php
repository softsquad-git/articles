<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function catchResponse(object $e)
    {
        return response()->json([
            'success' => 0,
            'msg' => $e->getMessage()
        ]);
    }

    protected function successResponse()
    {
        return response()->json([
            'success' => 1
        ]);
    }
}
