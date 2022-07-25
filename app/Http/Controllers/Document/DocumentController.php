<?php

namespace App\Http\Controllers\Document;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Document\Category;
use App\Models\Document\Document;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Models\Document\Document_has_user;
use App\Models\Document\Groupe;
use App\Models\People\Person;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $document = Document::where('user_id', Auth::user()->id)->with('categorie')->get();
        // $person = Person::get();
        // $group = Groupe::get();
        return Inertia::render('Document/Index',[

            'documents' => $document,
            // 'persons' => $person,
            // 'groupes' => $group
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get('nom')->pluck('nom');
        // dd($category);
        return Inertia::render('Document/Create',[

            'categories' => $category
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

            'titre' => ['required','string','max:225'],
            'auteur' => ['required','string','max:255'],
            'niveau_access' => ['required','integer'],
            'slug' => ['string','max:225'],
            'password' => ['string','max:225','nullable'],
            'categorie' => ['required','integer'],
            'description' => ['required','string'],
            'path' => ['required','file'],
            'date' => ['required']
        
        ]);

        $document = Document::create([

            'titre' => Request::get('titre'),
            'user_id' => Auth::user()->id,
            'auteur' => Request::get('auteur'),
            'niveau_access' => 1,
            'path' => 'Directory\'somethere',
            'slug' => Str::slug(Request::get('slug')),
            'password' => Hash::make(Request::get('password')),
            'category_id' => Request::get('categorie'),
            'description' => Request::get('description'),
            'date' => Request::get('date')
        
        ]);

        $document->save();

        $doc_access = Document_has_user::create([

            'user_id' => Auth::user()->id,
            'document_id' => $document->id 
        
        ]);

        $doc_access->save();

        

        return Redirect::route('documents.index')->with('success', 'document créé avec succès.');        
    }

    public function download(Request $request){
        $validator = Request::validate([
            'document_id' => ['required','integer']
        ]);

        $document = Document::where('id',Request::get('document_id'))->first()->get();

        $file = $document->path;

        $headers = array(
            'Content-Type: Application/pdf',
        );

        return Response::download($file, $document->titre, $headers);

        
    }

    public function read(Request $request){
        $validator = Request::validate([
            'document_id' => ['required','integer']
        ]);

        $document = Document::where('id',Request::get('document_id'))->first()->get();

        $file = $document->path;

        $headers = array(
            'Content-Type: Application/pdf',
        );

        return Response()->file($file,$headers);
        
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

    public function view_shared_docs(Request $request){

        $documents = Document::where('user_id',Auth::user()->id)->pluck('id')->toArray();
        
        $documents = Document_has_user::whereIn('document_id', $documents)->with('document')->first();
        // dd($documents);
        return Inertia::render('Document/Document_shared', [
            'documents' => $documents,
        ]);
    }

    public function share(Request $request){
        
        $validator = Request::validate([

            'user_id' => ["required_without:group_id","integer"],
            'group_id' => ["required_without:user_id","integer"],
            'document_id' => ["required","integer"],
        ]);
        
        if(Request::get('user_id') != null OR Request::get('user_id') != ''){
            Document_has_user::create([
                'user_id' => Person::where('id',Request::get('user_id'))->first()->id,
                'document_id' => Request::get('document_id')
            ])->save();
        
            return Redirect::route('documents.index')->with('success', 'document partagé avec succès.');
        }
        if(Request::get('group_id') != null OR Request::get('group_id') != ''){
            $group_members = Groupe::where('id', Request::get('group_id'))->get()->pluck('user_id');

            // dd($group_members);
            foreach ($group_members as $group_member){

                Document_has_user::create([
                    'user_id' => Person::where('id',$group_member)->first()->id,
                    'document_id' => Request::get('document_id')
                ])->save();
            }
                return Redirect::route('documents.index')->with('success', 'document partagé avec succès.');
            }
    }

    public function group_share(Request $request){
        
        $validator = Request::validate([
            'username' => ['required','string'],
            'group_id' => ['required','integer']
        ]);
        
        $group_members = Groupe::where('id', Request::get('group_id'))->get();

        foreach ($group_members as $group_member){

            Document_has_user::create([
                'user_id' => User::where('username',$group_member->user_id)->first()->id,
                'document_id' => Request::get('document_id')
            ])->save();
        }
            return Redirect::route('documents.index')->with('success', 'document partagé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all()->pluck('nom');
        $document = Document::where('id',$id)->with('categorie')->first();
        return Inertia::render('Document/Edit', [
            'document' => $document,
            'categories' => $categories
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
        $validator = Request::validate([

            'titre' => ['required','string','max:225'],
            'auteur' => ['required','string','max:255'],
            'niveau_access' => ['required','integer'],
            'slug' => ['string','max:225'],
            'password' => ['string','max:225','nullable'],
            'categorie' => ['required','integer'],
            'description' => ['required','string'],
            'path' => ['required','file'],
            'date' => ['required']

        ]);

        $document = Document::where('id',$id)->first();

        $document->update([

            'titre' => Request::get('titre'),
            'user_id' => Auth::user()->id,
            'auteur' => Request::get('auteur'),
            'niveau_access' => 1,
            'path' => 'Directory\'somethere',
            'slug' => Str::slug(Request::get('slug')),
            'password' => Hash::make(Request::get('password')),
            'category_id' => Request::get('categorie'),
            'description' => Request::get('description'),
            'date' => Request::get('date')

        ]);

        return Redirect::route('documents.index')->with('success', 'Document modifié avec succès.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::where('id',$id)->first();

        $document -> delete();

        return Redirect::route('documents.index')->with('success', 'Document supprimé avec succès.');
    }
}
