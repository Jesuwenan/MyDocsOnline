<?php

namespace App\Http\Controllers\Groups;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Groups\Group;
use App\Models\Document\Groupe;
use App\Http\Controllers\Controller;
use App\Models\Groups\GroupHasUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return Inertia::render('Groups/Index', [
            'groups' =>  Group::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Groups/Create',[
            'users' => User::get()
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
            'name' => ['required', 'string', 'max:225'],
            'users' => ['required', 'array'],
            'users.*.user.id' => ['required', 'exists:users,id']
        ]);
        
        $group = Group::create([
            'owner_id' => Auth::user()->id,
            'name' => Request::get('name')
        ]);

        foreach (Request::get('users') as $user) {
            GroupHasUser::create([
               'group_id' => $group->id,
               'user_id' => $user['user']['id']
           ]);
        }


        return Redirect::route('groups.index')->with('success','Groupe crée avec succèss.');
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
    public function edit(Group $group)
    {
        return Inertia::render('Groups/Edit', [
            'group' => Group::where('id', $group->id)->with('group_has_users')->first(),
        ]);
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
