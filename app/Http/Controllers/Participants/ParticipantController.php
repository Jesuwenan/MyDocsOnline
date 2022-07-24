<?php

namespace App\Http\Controllers\Participants;

use DateTime;
use Carbon\Carbon;
use App\Rules\Email;
use Inertia\Inertia;
use SimpleXMLElement;
use BaconQrCode\Writer;
use App\Models\Events\Event;
use App\Models\Events\Ticket;
use App\Models\People\Person;
use Ixudra\Curl\Facades\Curl;
use App\Rules\NationalRegistry;
use Illuminate\Validation\Rule;
use App\Models\Companies\Company;
use App\Exports\ParticipantExport;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Participants\EventDroit;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Participants\Participant;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Mail\Participants\ParticipantQrCode;
use App\Mail\Participants\InvitationResponse;
use App\Mail\Participants\ParticipantInvitation;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use App\Models\Participants\ParticipantHasEventDroit;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dd(Participant::where('person_id',null)->get());
        if(Auth::user()->is_admin) {
            $companies  = Company::with('events')->where('id','!=','1')->get();
            $company_ids = array();
            foreach ($companies as $company) {
                # code...
                array_push($company_ids,$company->id);
            }
            // $filename = 'participants-per-company-list.xls';
            // Excel::store(new ParticipantExport, $filename,'s3',null);
            // $events = Event::get();
            $total_participant  = Participant::filter(Request::only(['company','event','confirm']))->get()->count();
            $total_confirmed = Participant::where('confirm','!=',null)->where('refused',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_not_confirmed = Participant::where('confirm',null)->where('refused',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_refused = Participant::where('confirm',null)->where('refused','!=',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_present = Participant::where('present','!=',null)->filter(Request::only(['company','event','confirm']))->get()->count();
        } else {
            //dd(Auth::user()->company);
            $companies = array();
            array_push($companies, Auth::user()->company);
            $company_ids = array();
            foreach ($companies as $company) {
                # code...
                array_push($company_ids,$company->id);
            }
            //dd(Auth::user()->company->events);
            // $events = Auth::user()->company->events;
            $total_participant  = Participant::where('company_id',Auth::user()->company->id)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_confirmed = Participant::where('company_id',Auth::user()->company->id)->where('confirm','!=',null)->where('refused',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_not_confirmed = Participant::where('company_id',Auth::user()->company->id)->where('confirm',null)->where('refused',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_refused = Participant::where('company_id',Auth::user()->company->id)->where('confirm',null)->where('refused','!=',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            $total_present = Participant::where('company_id',Auth::user()->company->id)->where('present','!=',null)->filter(Request::only(['company','event','confirm']))->get()->count();
            // $filename = Auth::user()->company->name.'-participants-list.xls';
            // Excel::store(new ParticipantExport, $filename,'s3',null);
        }

        Request::get('pagination') != null ? $pagination = Request::get('pagination') : $pagination = 25;

        return Inertia::render('Participants/Index',[
            'filters' => Request::all(['search','company','event','confirm','pagination']),
            'participants' => Participant::with('company')
                ->with('event')
                ->with('person')
                ->whereIn('company_id',$company_ids)
                ->filter(Request::only(['search','company','event','confirm',]))
                ->paginate($pagination),

            'total_participant' => $total_participant,
            'total_confirmed' => $total_confirmed,
            'total_not_confirmed' => $total_not_confirmed,
            'total_refused' => $total_refused,
            'total_present' => $total_present,
            'companies' => $companies,
            'events'    => Event::get(),
            // 'file'  =>  Participant::participantListUrl()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin)
        {
            $companies  = Company::with('events')->where('id','!=',1)->get();

        }else{
            $companies = array();
            array_push($companies, Auth::user()->company);
        }

        return Inertia::render('Participants/Create', [
            'companies' => $companies,
            'events'    => Event::get(),
            'people'    => Person::get(),
            'event_droits'  => EventDroit::get()
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
            'company_id' => ['required','exists:companies,id'],
            'event_id' => ['required','exists:events,id'],
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'national_registry' => ['nullable','string','max:15',new NationalRegistry],
            'address' => ['nullable','string','max:255'],
            'postal_code' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'email' => ['required_without:phone','nullable','string','max:255',new  Email, Rule::unique('people','email')->ignore(Request::get('person_id'))],
            'number' => ['required_without:email','nullable','max:255', Rule::unique('people','phone')->ignore(Request::get('person_id'))],
            'event_droit'   =>  ['nullable','array'],
            'person_id'     =>  ['nullable','exists:people,id']
        ]);

        if(Request::get('person_id')) {
            $person = Person::where([
                'id'    =>  Request::get('person_id'),
            ])->first();
        } else {
            if(Request::get('phone')) {
                $person = Person::Where('phone',Request::get('number'))->first();
            } else {
                if(Request::get('email')) {
                    $person = Person::where([
                        'email'    =>  Request::get('email'),
                    ])->first();
                }
            }
        }

        if($person) {
            $company_id = Request::get('company_id');
            $event_id = Request::get('event_id');
            $person_id = Request::get('person_id');
            Request::validate([
                'person_id' => Rule::unique('participants')->where(function ($query) use($company_id,$event_id,$person_id) {
                    return $query->where('company_id', $company_id)
                        ->where('event_id', $event_id)
                        ->where('person_id', $person_id);
                })
            ],['person_id.unique' => 'Une entreprise ne peut inviter plus d\'une fois une personne  pour un même événement']);
        }

        if(!$person){
            $person = Person::create(
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

        }else{

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
        }

        $participant = Participant::create([
            'company_id' => Request::get('company_id'),
            'event_id' => Request::get('event_id'),
            'person_id' => $person->id
        ]);

        if(Request::get('event_droit'))
            ParticipantHasEventDroit::create([
                'participant_id'    =>  $participant->id,
                'event_droit_id'    =>  Request::get('event_droit')['id']
            ]);

        $phone = str_replace('+','',$participant->person->phone);

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
        $message = "Vous venez de recevoir une invitation de l'entreprise "
            .$participant->company->name."  pour participer à  un évènement organisé par le CHARNOY: ".$participant->event->name.' '.$participant->event->message
            ." Cliquez sur le lien ci dessous  pour confirmer votre participation:  ".route('participants.show.confirm.form',$participant->id)
            ." ou cliquez sur le lien ci dessous  pour refuser de participer à l'évènement:  ".route('participants.show.refused.form',$participant->id).".";

        $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$phone."&token=".$token."&sender=Charnoy";

        $response = Curl::to($url)->get();

        $participant_invitation = new ParticipantInvitation($participant);

        if(Request::get('email'))
            Mail::to(Request::get('email'))->send($participant_invitation);

        return Redirect::route('participants.index')->with('success', 'Participant créé avec succès.');
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
    public function edit(Participant $participant)
    {
        if(Auth::user()->is_admin)
        {
            $companies  = Company::where('id','!=',1)->get();
        }else{
            $companies = array();
            array_push($companies, Auth::user()->company);
        }

        $company = $participant->company;
        $event = $participant->event;

        return Inertia::render('Participants/Edit',[
            'participant'=> $participant,
            'companies' => $companies,
            'event'     => $event,
            'company'   => $company,
            'events'    => Event::get(),
            'person'    => $participant->person,
            'event_droits' => EventDroit::get(),
            'participant_has_event_droit'  => $participant->participant_has_event_droit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Participant $participant)
    {
        Request::validate([
            'company_id' => ['required','exists:companies,id'],
            'event_id' => ['required','exists:events,id'],
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'national_registry' => ['nullable','string','max:15',new NationalRegistry],
            'address' => ['nullable','string','max:255'],
            'postal_code' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'email' => ['required_without:phone','nullable','string','max:255',Rule::unique('people')->ignore(Request::get('person_id')),new  Email],
            'number' => ['required_without:email','nullable','max:255', Rule::unique('people','phone')->ignore(Request::get('person_id'))],
            'person_id' => ['required','exists:people,id']
        ]);

        if(Request::get('person_id')) {
            $person = Person::where([
                'id'    =>  Request::get('person_id'),
            ])->first();
        }else {
            if(Request::get('phone')) {
                $person = Person::Where('phone',Request::get('number'))->first();
            } else {
                if(Request::get('email')) {
                    $person = Person::where([
                        'email'    =>  Request::get('email'),
                    ])->first();
                }
            }
        }

        if($person) {
            $company_id = Request::get('company_id');
            $event_id = Request::get('event_id');
            $person_id = Request::get('person_id');
            Request::validate([
                'person_id' => Rule::unique('participants')->where(function ($query) use($company_id,$event_id,$person_id) {
                    return $query->where('company_id', $company_id)
                        ->where('event_id', $event_id)
                        ->where('person_id', $person_id);
                })->ignore($participant->id)
            ],['person_id.unique' => 'Une entreprise ne peut inviter plus d\'une fois une personne  pour un même événement']);
        }

        // Request::validate([
        //     'person_id'     =>  ['required','exists:people,id']
        // ]);

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

        $participant->update([
            'company_id' => Request::get('company_id'),
            'event_id' => Request::get('event_id'),
            'person_id' => $person->id
        ]);

        $participant->update([
            'person_id' => $person->id
        ]);

        if($participant->participant_has_event_droit){
            if (!Request::get('event_droit')) {
                $participant->participant_has_event_droit->delete();
            }
            else
                $participant->participant_has_event_droit->update([
                    'participant_id'    =>  $participant->id,
                    'event_droit_id'    =>  Request::get('event_droit')['id']
                ]);
        }else{
            if(Request::get('event_droit'))
                ParticipantHasEventDroit::create([
                    'participant_id'    =>  $participant->id,
                    'event_droit_id'    =>  Request::get('event_droit')['id']
                ]);
        }

        return Redirect::route('participants.index')->with('success', 'Participant modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant)
    {
        $participant->delete();
        return Redirect::route('participants.index')->with('success', 'Participant supprimé avec succès.');
    }

    public function sendMail(Request $request)
    {
        $participant = Participant::where('id',Request::get('participant_id'))->first();

        $participant_invitation = new ParticipantInvitation($participant);

        if($participant->person->email)
        {
            if(!$participant->confirm && !$participant->refused)
            {
                Mail::to($participant->person->email)->send($participant_invitation);

                $date = new DateTime();
                $participant->created_at = $date->getTimestamp();
                $participant->save();

                return Redirect::route('participants.index')->with('success', 'Mail d\'invitation envoyé avec succès.');

            }else{
                return Redirect::route('participants.index')->with('error', 'Le mail n\'est pas renvoyé car le participant à déjà confirmé ou refusé l\'invitation.');
            }

        }else{
            return Redirect::route('participants.index')->with('error', 'Veuillez définir une adresse mail pour effectuer cette action.');
        }
        


    }

    public function sendSms(Request $request)
    {
        $participant = Participant::where('id',Request::get('participant_id'))->first();

        if($participant->person->phone)
        {
            if(!$participant->confirm && !$participant->refused)
            {
                $phone = str_replace('+','',$participant->person->phone);
                //dd($phone);

                $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
                $message = "Vous venez de recevoir une invitation de l'entreprise "
                    .$participant->company->name."  pour participer à  un évènement organisé par le CHARNOY: ".$participant->event->name.' '.$participant->event->message
                    ." Cliquez sur le lien ci dessous  pour confirmer votre participation:  ".route('participants.show.confirm.form',$participant->id)
                    ." ou cliquez sur le lien ci dessous  pour refuser de participer à l'évènement:  ".route('participants.show.refused.form',$participant->id).".";

                $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$phone."&token=".$token."&sender=Charnoy";

                $response = Curl::to($url)->get();

                $response = new SimpleXMLElement($response);
                //dd($response);

                if($response->status!=1 && $response->message!="OK")
                    return Redirect::route('participants.index')->with('error', $response->message);
                
                $date = new DateTime();
                $participant->created_at = $date->getTimestamp();
                $participant->save();

                return Redirect::route('participants.index')->with('success', 'Sms d\'invitation envoyé avec succès.');

            }else{
                return Redirect::route('participants.index')->with('error', 'Le sms n\'est pas renvoyé car le participant à déjà confirmé ou refusé l\'invitation.');
            }
            
        }else{
            return Redirect::route('participants.index')->with('error', 'Veuillez définir un numéro de téléphone pour effectuer cette action..');
        }
        
    }

    public function showConfirmInviationForm($id)
    {
        if(Participant::with('event')->with('company')->where('id',$id)->first())
            if(Participant::with('company')->with('person')->where('id',$id)->first()->confirm || Participant::with('company')->where('id',$id)->first()->refused)
                return Redirect::route('response')->with('error', 'Vous avez déjà confirmer ou refuser votre participation ');

        return Inertia::render('Participants/ShowConfirmForm', [
            'participant' => Participant::with('event')->with('person')->with('company')->where('id',$id)->first(),
        ]);

    }

    public function confirmInviation(Request $request)
    {
        Request::validate([
            'participant_id' => ['required','exists:participants,id'],
            'company_id' => ['required','exists:companies,id'],
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'national_registry' => ['nullable','string','max:15',new NationalRegistry],
            'address' => ['required','string','max:255'],
            'postal_code' => ['nullable','string','max:255'],
            'city' => ['nullable','string','max:255'],
            'email' => ['required','nullable','string','max:255',Rule::unique('people')->ignore(Request::get('person_id')),new  Email],
            'phone' => ['required','nullable','regex:/^\d*$/','max:255',Rule::unique('people')->ignore(Request::get('person_id'))],
            'term_and_condition' => ['required','boolean'],
            'about_covid' => ['required',Rule::in(['Vacciné','Test PCR'])]
        ]);

        $participant  = Participant::with('company')->where('id',Request::get('participant_id'))->first();

        $person = Person::where([
            'id' => $participant->person_id
        ])->first();

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

        $participant->update(
            Request::only(
                'company_id',
                'event_id',
                'term_and_condition',
                'about_covid'
            )
        );

        $participant->update([
            'person_id' => $person->id
        ]);

        $date = new DateTime();

        $participant->update([
            'confirm'   => $date->format('Y-m-d H:i:s'),
            'refused'   => null
        ]);

        $invitation_response = new InvitationResponse($participant,true);
        
        Mail::to($participant->company->email)->send($invitation_response);

        // $renderer = new ImageRenderer(
        //     new RendererStyle(400),
        //     new ImagickImageBackEnd()
        // );
        // $writer = new Writer($renderer);  
        // $qr_image = base64_encode($writer->writeString($participant->id));
        // Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
        // $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));

        $qr = QrCode::format('svg')->size(400)->backgroundColor(255,255,255)->generate($participant->id);
        $qr_image = base64_encode($qr);
        Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
        $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));

        if(Ticket::where(['name' => 'qr_code_'.$participant->id,])->first())
        {
            $code =  Ticket::where(['name' => 'qr_code_'.$participant->id,])->first()->code;
        }else{
            $code =  $this->createCode();
            Ticket::create([
                'name' => 'qr_code_'.$participant->id,
                'code'  => $code
            ]);
        }
            
        $participant_qr_code = new ParticipantQrCode(
            $code,
            $participant
        );

        Mail::to($person->email)->send($participant_qr_code);

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
        $message = 'Merci d’avoir confirmé votre participation à l’événement '.$participant->event->name.' organisé par le CHARNOY, '.$participant->event->message." Cliquez sur le lien pour afficher votre ticket d’entrée : ".URL::to('/events/qr-code/'.$code);

        $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$person->phone."&token=".$token."&sender=Charnoy";

        Curl::to($url)->get();

        return Redirect::route('response')->with('success', 'Invitation confirmée avec succès.');
    }

    public function showRefusedInviationForm($id)
    {
        if(Participant::with('event')->with('company')->where('id',$id)->first())
            if(Participant::with('company')->where('id',$id)->first()->refused || Participant::with('company')->where('id',$id)->first()->confirm)
                return Redirect::route('response')->with('error', 'Vous avez déjà refuser ou confirmer de participer à cet évènement. ');

        return Inertia::render('Participants/ShowRefusedForm', [
            'participant' => Participant::with('event')->with('company')->where('id',$id)->first(),
        ]);

    }

    public function refusedInviation(Request $request)
    {
        Request::validate([
            'participant_id' => ['required','exists:participants,id'],
        ]);

        $participant  = Participant::with('company')->with('event')->where('id',Request::get('participant_id'))->first();

        $date = new DateTime();

        $participant->update([
            'refused'   => $date->format('Y-m-d H:i:s'),
            'confirm'   => null
        ]);

        $invitation_response = new InvitationResponse($participant,false);
        
        Mail::to($participant->company->email)->send($invitation_response);

        return Redirect::route('response')->with('success', 'Invitation refusée avec succès.');

    }

    public function sendSmsToSelectedParticipants(Request $request)
    {
        Request::validate([
            'participant_list' => ['required','array'],
        ]);

        foreach (Request::get('participant_list') as $item) {
            # code...
            $participant = Participant::where('id',$item['id'])->with('company')->with('event')->first();

            if($participant->person->phone){
                
                if(!$participant->confirm && !$participant->refused)
                {
                    $phone = str_replace('+','',$participant->person->phone);

                    $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
                    $message = "Vous venez de recevoir une invitation de l'entreprise "
                        .$participant->company->name."  pour participer à  un évènement organisé par le CHARNOY: ".$participant->event->name.' '.$participant->event->message
                        ." Cliquez sur le lien ci dessous  pour confirmer votre participation:  ".route('participants.show.confirm.form',$participant->id)
                        ." ou cliquez sur le lien ci dessous  pour refuser de participer à l'évènement:  ".route('participants.show.refused.form',$participant->id).".";

                    $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$phone."&token=".$token."&sender=Charnoy";
        
                    $response = Curl::to($url)->get();
        
                    //dd($response);
    
                    $response = new SimpleXMLElement($response);
        
        
                    if($response->status!=1 && $response->message!="OK")
                        return Redirect::route('participants.index')->with('error', $response->message);
                    
                    $date = new DateTime();
                    $participant->created_at = $date->getTimestamp();
                    $participant->save();
                }
            }

        }

        return Redirect::route('participants.index')->with('success', 'Sms d\'invitation envoyé avec succès.');
    }

    public function sendMailToSelectedParticipants(Request $request)
    {
        Request::validate([
            'participant_list' => ['required','array'],
        ]);

        foreach (Request::get('participant_list') as $item)
        {
            $participant = Participant::where('id',$item['id'])->with('company')->with('event')->first();

            if($participant->person->email)
            {
                if(!$participant->confirm && !$participant->refused)
                {
                    $participant_invitation = new ParticipantInvitation($participant);
        
                    Mail::to($participant->person->email)->send($participant_invitation);
        
                    $date = new DateTime();
                    $participant->created_at = $date->getTimestamp();
                    $participant->save();
                }
            }

        }

        return Redirect::route('participants.index')->with('success', 'Mail d\'invitation envoyé avec succès.');
        
    }

    public function conditionGeneral(Request $request)
    {
        return Inertia::render('Participants/ConditionGeneral',[]);
    }

    public function sendTicket(Request $request)
    { 
        //dd(Request::get('participant')->id);
        Request::validate([
            'participant_id' => ['required','exists:participants,id']
        ]);

        $participant = Participant::with('company')->with('event')->where('id',Request::get('participant_id'))->first();
       
        if($participant->confirm)
        {
            // $renderer = new ImageRenderer(
            //     new RendererStyle(400),
            //     new ImagickImageBackEnd()
            // );
            // $writer = new Writer($renderer);  
            // $qr_image = base64_encode($writer->writeString($participant->id));
            // Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
            // $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));

            $qr = QrCode::format('svg')->size(400)->backgroundColor(255,255,255)->generate($participant->id);
            $qr_image = base64_encode($qr);
            Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
            $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));


            if(Ticket::where(['name' => 'qr_code_'.$participant->id,])->first())
            {
                $code =  Ticket::where(['name' => 'qr_code_'.$participant->id,])->first()->code;
            }else{
                $code =  $this->createCode();
                Ticket::create([
                    'name' => 'qr_code_'.$participant->id,
                    'code'  => $code
                ]);
            }
                
            $participant_qr_code = new ParticipantQrCode(
                $qr_code,
                $participant
            );

            if($participant->person->email){
                Mail::to($participant->person->email)->send($participant_qr_code);
            }

            $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
            $message = 'Merci d’avoir confirmé votre participation à l’événement '.$participant->event->name.' organisé par le CHARNOY, '.$participant->event->message." Cliquez sur le lien pour afficher votre ticket d’entrée : ".URL::to('/events/qr-code/'.$code);

            $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$participant->person->phone."&token=".$token."&sender=Charnoy";

            Curl::to($url)->get();

            return Redirect::route('participants.index')->with('success', 'Le ticket a été envoyé avec succès.');

        }else{
            return Redirect::route('participants.index')->with('error', 'Le participant selectionner n\'a pas confirmé sa participation à l\'évènement.');

        }
        

    }

    public function sendTickets(Request $request)
    { 
        //dd(Request::get('participant')->id);
        Request::validate([
            'participant_list' => ['required','array'],
        ]);

        foreach (Request::get('participant_list') as $item)
        {
            $participant = Participant::where('id',$item['id'])->with('company')->with('event')->first();

            if($participant->confirm)
            {
                // $renderer = new ImageRenderer(
                //     new RendererStyle(400),
                //     new ImagickImageBackEnd()
                // );
                // $writer = new Writer($renderer);  
                // $qr_image = base64_encode($writer->writeString($participant->id));
                // Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
                // $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));

                $qr = QrCode::format('svg')->size(400)->backgroundColor(255,255,255)->generate($participant->id);
                $qr_image = base64_encode($qr);
                Storage::disk('s3')->put('qr_code_'.$participant->id.'.png', base64_decode($qr_image));
                $qr_code = Storage::temporaryUrl('qr_code_'.$participant->id.'.png',Carbon::now()->addDays(5));


                if(Ticket::where(['name' => 'qr_code_'.$participant->id,])->first())
                {
                    $code =  Ticket::where(['name' => 'qr_code_'.$participant->id,])->first()->code;
                }else{
                    $code =  $this->createCode();
                    Ticket::create([
                        'name' => 'qr_code_'.$participant->id,
                        'code'  => $code
                    ]);
                }
                    
                $participant_qr_code = new ParticipantQrCode(
                    $qr_code,
                    $participant
                );

                if($participant->person->email){
                    Mail::to($participant->person->email)->send($participant_qr_code);
                }

                $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMjA0OCIsImlhdCI6MTYyNTIxOTc2M30.Xa1mIztZT8o5cpEkFn8I0_VPRzOX4hk_irLSGLBDl0s";
                $message = 'Merci d’avoir confirmé votre participation à l’événement '.$participant->event->name.' organisé par le CHARNOY, '.$participant->event->message." Cliquez sur le lien pour afficher votre ticket d’entrée : ".URL::to('/events/qr-code/'.$code);

                $url = "https://api.smsfactor.com/send?text=".urlencode($message)."&to=".$participant->person->phone."&token=".$token."&sender=Charnoy";

                Curl::to($url)->get();

                return Redirect::route('participants.index')->with('success', 'Les tickets ont été envoyés avec succès.');

            }
        }

    }

    public function exportParticipant() {        
        if(Auth::user()->is_admin) {
            $filename = 'participants-per-company-list.xls';
        } else {
            $filename = Auth::user()->company->name.'-participants-list.xls';
        }
        return Excel::download( new ParticipantExport, $filename);
    }

    public function createCode()
    {
        $code = $this->generateCode();
        if(!Ticket::where('code',$code)->first())
            return $code;
        else
            $this->createCode();
    }

    public function generateCode() {

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
