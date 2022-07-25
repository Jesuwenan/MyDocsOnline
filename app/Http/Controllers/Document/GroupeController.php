<?php

namespace App\Http\Controllers\Document;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Document\Groupe;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Document\Groupe_has_member;
use App\Models\People\Person;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupes = Groupe::where('user_id', Auth::user()->id)->paginate(10);
        $people = Person::all()->pluck('username');
        $members = Groupe_has_member::groupby('group_id');
        // dd($members);
        return Inertia::render('Groupe/Index', [
            'groupes' => $groupes,
            'person' => $people
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $people = Person::all()->pluck('username');
        // dd($people);
        return Inertia::render('Groupe/Create',[
            'users' => $people
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
        $validator = Request::validate([
            'group' => ['required', 'string', 'max:225'],
            
        ]);
        
        $group = Groupe::create([
            'user_id' => Auth::user()->id,
            'group_name' => Request::get('group')
        ]);

        $group->save();

        return Redirect::route('groupe.index')->with('success','Groupe crée.');
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
        $group = Groupe::where('id', $id)->first()->get();

        return Inertia::render('Groupe/Edit', [
            'groupe' => $group,
        ]);

        return Redirect::route('Groupe/index')->with('success','Groupe bien édité');
    }

    public function addMemberToGroup(Request $request, $id)
    {

        $validator = Request::validate([
            'username' => ['required', 'array']
        ]);

        Groupe_has_member::create([
            'user_id' => Person::where('username', Request::get('username'))->first()->id,
            'group_id' => $id
        ])->save();

        return Redirect::route('groupe.index')->with('success','utilisateur bien ajouté à ce groupe');
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
        $validator = Request::validate([
            'group_name' => ['required', 'string', 'max:225']
        ]);

        $group = Groupe::where('id', $id)->first();

        $group->update([
            'groupe_name' => Request::get('group_name')
        ]);

        return Redirect::route('groupe.index')->with('success', 'Groupe modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Groupe::where('id', $id)->first();

        $group->delete();

        return Redirect::route('groupe.index')->with('success', 'Groupe supprimé avec succès.');
    }
}
