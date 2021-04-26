<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller {

    public function login(Request $request)
    {
        return view('pages.login');
    }
}
