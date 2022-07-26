<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\Document\DocumentShared;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Bars\BarController;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\Helps\HelpController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Groups\GroupController;
// use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Events\ScanQrController;
use App\Http\Controllers\People\PersonController;
use App\Http\Controllers\Document\GroupeController;
use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Responses\ResponseController;
use App\Http\Controllers\Document\DocumentSharedController;
use App\Http\Controllers\Participants\ParticipantController;
use App\Http\Controllers\Consummation\ConsummationsController;
use App\Http\Controllers\Consummations\ConsummationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::redirect('/', 'login');

    Route::redirect('dashboard', 'users');

    Route::resource('users', UserController::class)
        ->middleware('auth:sanctum');

    Route::resource('documents', DocumentController::class)
        ->middleware('auth:sanctum');

    Route::resource('document_share', DocumentController::class)
    ->middleware('auth:sanctum');

    Route::resource('groups', GroupController::class)
        ->middleware('auth:sanctum');

    Route::post('addMemberToGroup/{id}',[GroupeController::class, 'addMemberToGroup'])
        ->name('groupe.addMemberToGroup');

    Route::post('share', [DocumentController::class, 'share'])
        ->name('documents.share');

    Route::post('share', [DocumentController::class, 'share'])
    ->name('documents.share');

        Route::post('user_share', [DocumentController::class, 'user_share'])
        ->name('documents.user_share');

    Route::get('view_shared_docs', [DocumentController::class, 'view_shared_docs'])
        ->name('documents.view.sharedDocs');

    Route::get('view_document_shared', [DocumentController::class, 'share'])
        ->name('documents.share_docs');

    Route::resource('people', PersonController::class)->middleware('auth:sanctum');

    Route::get('filepond/api/process', [FilepondController::class, 'show']);
