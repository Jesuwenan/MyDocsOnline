<?php

namespace App\Models\Participants;

use Carbon\Carbon;
use App\Models\Events\Event;
use App\Models\Events\Ticket;
use App\Models\People\Person;
use App\Models\Companies\Company;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'selected',
        'ticket'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id')->with('events');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id')->with('event_has_products');
    }

    public function person()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }

    public function participant_has_event_droit(){
        return $this->hasOne(ParticipantHasEventDroit::class,'participant_id','id')->with('event_droit');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at'] )->format('d/m/y H:i');
    }

    public function getConfirmAttribute()
    {
        if($this->attributes['confirm'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['confirm'] )->format('d/m/y H:i');
    }

    public function getRefusedAttribute()
    {
        if($this->attributes['refused'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['refused'] )->format('d/m/y H:i');
    }

    public function getPresentAttribute()
    {
        if($this->attributes['present'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['present'] )->format('d/m/y H:i');
    }

    public function getSelectedAttribute()
    {
        return false;
    }

    public function getTicketAttribute()
    {
        if(Ticket::where('name','qr_code_'.$this->attributes['id'])->first()){
            $code = Ticket::where('name','qr_code_'.$this->attributes['id'])->first()->code;
            return URL::to('/events/qr-code/'.$code);
        }else{
            return URL::to('/events/qr-code/'.'0');
        }   

    }

    public  static function participantListUrl()
    {
        Auth::user()->is_admin ? $filename = 'participants-per-company-list.xls' : $filename = Auth::user()->company->name.'-participants-list.xls';
        return Storage::temporaryUrl($filename,Carbon::now()->addMinutes(10));
    }

    public function scopeFilter($query, array $filters)
    {
        //dd($filters);
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereHas('person', function($query) use ($search){
                $query->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', '=' ,$search);
            });
        })->when($filters['company'] ?? null, function ($query, $company){
            $query->whereHas('company', function($query) use ($company){
                $query->where('id',$company);
            });
        })->when($filters['event'] ?? null, function ($query, $event){
            $query->whereHas('event', function($query) use ($event){
                $query->where('id',$event);
            });
        })->when($filters['confirm'] ?? null, function ($query, $confirm){
            $confirm==='Oui' ? $query->where('confirm','!=',null) :$query->where('confirm',null);
        });

        if(!array_key_exists('event',$filters)){
            $events = Event::get();
            $active_event  = null;
            foreach ($events as $event)
            {
                if($event->status==='In Progress')
                {
                    $active_event = $event;
                }
            }

            if($active_event){
                $query->where('event_id',$active_event->id);
            }
        }
        
    }
}
