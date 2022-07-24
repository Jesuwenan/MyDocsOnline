<?php

namespace App\Http\Controllers\Document;

use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Document\Document;
use App\Http\Controllers\Controller;
use App\Models\Document\Category;
use App\Models\Document\Document_has_user;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $document = Document::where('user_id', Auth::user()->id)->get();

        // dd($document);
        return Inertia::render('Document/Index',[

            'document' => $document
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
        $category = Category::all();

        return Inertia::render('Document/Create',[

            'category' => $category
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

        $documents_shared = Document_has_user::whereIn('document_id', $documents)->with(Document::class)->get();

        return Inertia::render('Document/Document_shared', [
            'document_shared' => $documents_shared
        ]);
    }

    public function share(Request $request){
        
        $validator = Request::validate([

            'username' => ['required','string'],
            'document_id' => ['required','integer']
        
        ]);

        Document_has_user::create([

            'user_id' => User::where('username',Request::get('username'))->first()->id,
            'document_id' => Request::get('document_id')
        
        ])->save();
        
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
        $document = Document::where('id',$id)->first();
        return Inertia::render('Document/Edit', [

            'document' => $document,

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
