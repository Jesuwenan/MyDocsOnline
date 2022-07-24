<?php

namespace App\Http\Controllers\Api\People;

use App\Models\People\Person;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class PersonController extends Controller
{
    //
    public function searchPerson(Request $request)
    {
        Request::validate([
            'email' => ['required_without:phone','exists:people,email'],
            'phone' => ['required_without:email','exists:people,phone']
        ]);

        if(Request::get('phone')) {
            $person = Person::where([
                'phone'    =>  Request::get('phone'),
            ])->first();
        } else{
            $person = Person::where([
                'email'    =>  Request::get('email'),
            ])->first();
        }

        if($person){
            return response()->json([
                "status"  => true,
                "person" => $person
            ],200);
            
        }else{
            return response()->json([
                "status"  => false,
                "person"  =>  'Not found'
            ],200);
        }
    }
}
