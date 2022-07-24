<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Bars\BarController;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\Helps\HelpController;
use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Events\ScanQrController;
use App\Http\Controllers\People\PersonController;
// use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Responses\ResponseController;
use App\Http\Controllers\Participants\ParticipantController;
use App\Http\Controllers\Consummation\ConsummationsController;
use App\Http\Controllers\Consummations\ConsummationController;
use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\Document\DocumentSharedController;
use App\Http\Controllers\Document\GroupeController;
use App\Models\Document\DocumentShared;

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

    // Route::redirect('register', 'register');

    Route::redirect('dashboard', 'documents');

    Route::resource('participants', ParticipantController::class)
        ->middleware('auth:sanctum');

    Route::resource('documents', DocumentController::class)
        ->middleware('auth:sanctum');

    Route::resource('document_share', DocumentController::class)
    ->middleware('auth:sanctum');

    Route::resource('groupe', GroupeController::class)
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

    Route::post('/participants/send-mail',[ParticipantController::class, 'sendMail'])
        ->name('participants.send.mail')
        ->middleware('auth:sanctum');

    Route::post('/participants/send-sms',[ParticipantController::class, 'sendSms'])
        ->name('participants.send.sms')->middleware('auth:sanctum');

    Route::post('/participants/send-sms-selected-participants',[ParticipantController::class, 'sendSmsToSelectedParticipants'])
        ->name('participants.send.sms.selected.participants')
        ->middleware('auth:sanctum');

    Route::post('/participants/send-mail-selected-participants',[ParticipantController::class, 'sendMailToSelectedParticipants'])
        ->name('participants.send.mail.selected.participants')->middleware('auth:sanctum');

    Route::get('/confirm-invitation/{id}',[ParticipantController::class, 'showConfirmInviationForm'])
        ->name('participants.show.confirm.form');

    Route::get('/response',[ResponseController::class, 'Response'])->name('response');

    Route::post('/confirm-invitation',[ParticipantController::class, 'confirmInviation'])
        ->name('participants.confirm');

    Route::get('/refused-invitation/{id}',[ParticipantController::class, 'showRefusedInviationForm'])
        ->name('participants.show.refused.form');

    Route::get('/failed',[ResponseController::class, 'refusedResponse'])->name('failed.response');

    Route::post('/refused-invitation',[ParticipantController::class, 'refusedInviation'])
        ->name('participants.refused');

    Route::get('/condition-general',[ParticipantController::class, 'conditionGeneral'])
        ->name('participants.condition.general');

    Route::post('/participants/send-ticket',[ParticipantController::class, 'sendTicket'])
        ->name('participants.send.ticket')->middleware('auth:sanctum');

    Route::post('/participants/send-tickets',[ParticipantController::class, 'sendTickets'])
        ->name('participants.send.tickets')->middleware('auth:sanctum');

    Route::get('/participants/export/list',[ParticipantController::class, 'exportParticipant'])
        ->name('participants.export.list')->middleware('auth:sanctum');

    Route::resource('people', PersonController::class)->middleware('auth:sanctum');

    Route::get('filepond/api/process', [FilepondController::class, 'show']);
