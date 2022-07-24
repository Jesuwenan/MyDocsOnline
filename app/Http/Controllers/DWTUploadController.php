<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DWTUploadController extends Controller
{
    public function index(){
        return view('dwt_upload');
    }

    public function upload(Request $request){
        $validation = Validator::make($request->all(), [
            
        ]);
    }
}
