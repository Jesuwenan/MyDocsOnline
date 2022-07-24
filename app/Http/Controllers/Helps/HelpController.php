<?php

namespace App\Http\Controllers\Helps;

use App\Rules\Email;
use Inertia\Inertia;
use App\Models\Helps\Help;
use App\Rules\PhoneNumber;
use App\Mail\Helps\HelpMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return Inertia::render('Helps/Create',[
            'company'   => Auth::user()->company
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Request::validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','string','max:255',new  Email],
            'country_code' => ['required'],
            'phone' => ['required','string',
                'max:255',
                new PhoneNumber(Request::get('country_code'))
            ],
            'question'  => ['required','string']
        ]);

        $help_mail = new  HelpMail(
            Request::get('name'),
            Request::get('number'),
            Request::get('email'),
            Request::get('question'),
            Auth::user()->company,
        );

        Mail::to('valerio@facilesolution.com')
            ->bcc('egbavou@outlook.fr')
            ->send($help_mail);

        return Redirect::route('companies.index')->with('success', 'Demande d\'aide envoyé  avec succès.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
