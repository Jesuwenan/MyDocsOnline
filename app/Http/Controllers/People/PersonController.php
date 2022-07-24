<?php

namespace App\Http\Controllers\People;

use App\Rules\Email;
use Inertia\Inertia;
use App\Rules\PhoneNumber;
use App\Exports\PeopleExport;
use App\Models\People\Person;
use Ixudra\Curl\Facades\Curl;
use App\Rules\NationalRegistry;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Mail\UserMail;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Excel::store(new PeopleExport, 'people-list.xls', 's3', null);
        return Inertia::render('People/Index', [
            'filters' => Request::all('search'),
            'people'  => Person::filter(Request::only('search'))->paginate(50),
            'file'  =>   Person::peopleListUrl(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return Inertia::render('People/Create', [
            'sexe' => ['Masculin', 'Féminin']
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sexe' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'email' => ['required_without:phone', 'nullable', 'string', 'max:255', Rule::unique('people'), new  Email],
            'country_code' => ['required_without:email', 'nullable'],
            'phone' => [
                'required_without:email', 'nullable',
                'max:255', Rule::unique('people'),
                new PhoneNumber(Request::get('country_code'))
            ],
        ]);

        $person = Person::create(
            Request::only(
                'first_name',
                'last_name',
                'username',
                'sexe',
                'pseudo',
                'email',
            )
        );

        $person->update([
            'phone' => Request::get('number')
        ]);

        // $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
        // $message = "Vous avez un compte au sein de l'application All Docs Online avec le nom d'utilisateur " . $person->username;
        
        
        // $participant_invitation = new userMail($person);

        // if (Request::get('email'))
        //     Mail::to(Request::get('email'))->send($participant_invitation);

        return Redirect::route('people.index')->with('success', 'Personne créé avec succès.');
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
    public function edit(Person $person)
    {
        //
        return Inertia::render('People/Edit', [
            'person'    => $person
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
        //dd(Request::get('number'));
        Request::validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'national_registry' => ['nullable', 'string', 'max:15', new NationalRegistry],
            'address' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'email' => ['required_without:phone', 'nullable', 'string', 'max:255', Rule::unique('people')->ignore($person->id), new  Email],
            'country_code' => ['required_without:email', 'nullable'],
            'phone' => [
                'required_without:email', 'nullable',
                'max:255', Rule::unique('people')->ignore($person->id),
                new PhoneNumber(Request::get('country_code'))
            ],
        ]);

        $person->update(
            Request::only(
                'first_name',
                'last_name',
                'national_registry',
                'address',
                'postal_code',
                'city',
                'email',
            )
        );

        $person->update([
            'phone' => Request::get('number')
        ]);

        return Redirect::route('people.index')->with('success', 'Personne modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
        $person->delete();

        return Redirect::route('people.index')->with('success', 'Personne supprimée avec succès.');
    }
}
