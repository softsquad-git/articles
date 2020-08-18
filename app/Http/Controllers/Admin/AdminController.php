<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'ip_1' => $request->ip(),
            'ip_2' => $request->getClientIp()
        ]);
    }
}
