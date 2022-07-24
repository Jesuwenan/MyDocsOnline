<?php

namespace App\Exports;

use App\Models\Companies\Company;
use App\Models\Participants\Participant;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParticipantExport implements FromArray,WithHeadings
{

    protected $participants;

    public function __construct()
    {

        if(Auth::user()->is_admin)
            $participants =  Participant::with('event')->with('company')->with('person')->where('company_id','!=',1)->orderBy('event_id')->get();
        else 
            $participants =  Participant::with('event')->with('company')->with('person')->where('company_id',Auth::user()->company->id)->orderBy('event_id')->get();

        $this->participants = array();

        foreach ($participants as $participant) {
            # code...
            $item =  array();
            $item['id'] = $participant->id;
            $item['event'] = $participant->event ? $participant->event->name : '';
            $item['company'] = $participant->company ? $participant->company->name : '';
            $item['last_name'] = $participant->person ?  $participant->person->last_name : '';
            $item['first_name'] = $participant->person ? $participant->person->first_name : '';
            $item['national_registry'] = $participant->person ? $participant->person->national_registry : '';
            $item['address'] = $participant->person ? $participant->person->address : '';
            $item['postal_code'] = $participant->person ? $participant->person->postal_code : '';
            $item['city'] = $participant->person ? $participant->person->city : '';
            $item['email'] = $participant->person ? $participant->person->email : '';
            $item['phone'] = $participant->person ? $participant->person->phone : '';
            $item['covid'] = $participant->about_covid;
            $item['term'] = $participant->term_and_condition;
            $item['created_at'] = $participant->created_at;
            $item['confirm']  = $participant->confirm;
            $item['refused']  = $participant->refused;
            $item['present']  = $participant->present;

            array_push($this->participants,$item); 
        }
    }
    
    /**
     * @return array
     */
    public function array(): array
    {
        return   $this->participants;
    }


    public function headings(): array
    {
        return [
            '#',
            'Evénement',
            'Entreprise',
            'Nom',
            'Prénom',
            'Registre National',
            'Adresse',
            'Code Postal',
            'Ville',
            'Email',
            'Phone',
            'COVID',
            'Term',
            'Invité',
            'Confirmé',
            'Refusé',
            'Présent'
        ];
    }
}
