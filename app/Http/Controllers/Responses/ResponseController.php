<?php

namespace App\Http\Controllers\Responses;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResponseController extends Controller
{
    //

    public function Response()
    {
        return Inertia::render('Responses/ConfirmResponse', []); 
    }

  
}
