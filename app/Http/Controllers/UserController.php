<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Rules\Email;
use Inertia\Inertia;
use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'filters' => Request::all('search'),
            'people'  => User::filter(Request::only('search'))->paginate(50),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
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
        Request::validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sexe' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'email' => ['required_without:phone', 'nullable', 'string', 'max:255', Rule::unique('users'), new  Email],
            'country_code' => ['required_without:email', 'nullable'],
            'phone' => [
                'required_without:email', 'nullable',
                'max:255', Rule::unique('users'),
                new PhoneNumber(Request::get('country_code'))
            ],
        ]);

        $person = User::create(
            Request::only(
                'first_name',
                'last_name',
                'username',
                'sexe',
                'pseudo',
                'email',
            )
        );

        $password = $this->generatePassword();

        $person->update([
            'phone'     => Request::get('number'),
            'password'  =>  Hash::make($password)
        ]);

        // $company_credential = new CompanyCredential(
        //     Request::get('name'),
        //     Request::get('connexion_email'),
        //     $password,
        // );

        // Mail::to(Request::get('connexion_email'))
        //     ->cc(Request::get('email'))
        //     ->send($company_credential);

        return Redirect::route('users.index')->with('success', 'Utilisateur créé avec succès.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
        return Inertia::render('Users/Edit', [
            'person'    => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Request::validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'sexe' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'email' => ['required_without:phone', 'nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id), new  Email],
            'country_code' => ['required_without:email', 'nullable'],
            'phone' => [
                'required_without:email', 'nullable',
                'max:255', Rule::unique('users')->ignore($user->id),
                new PhoneNumber(Request::get('country_code'))
            ],
        ]);

        $user->update(
            Request::only(
                'first_name',
                'last_name',
                'username',
                'sexe',
                'pseudo',
                'email',
            )
        );

        $user->update([
            'phone' => Request::get('number')
        ]);

        return Redirect::route('users.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::route('users.index')->with('success', 'Utilisateur supprimée avec succès.');
    }


    public function generatePassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
