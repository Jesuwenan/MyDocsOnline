<?php

namespace App\Models\Consummation;

use Carbon\Carbon;
use App\Models\Events\Event;
use App\Models\Companies\Company;
use App\Models\Events\EventHasProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Participants\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consummation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class,'event_id','id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    
    public function product()
    {
        return $this->belongsTo(EventHasProduct::class, 'event_has_product_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class)->with('participant_has_event_droit')->with('person');
    }

    public  static function consummationsListUrl()
    {
        return Storage::temporaryUrl('consummations-list.xls',Carbon::now()->addMinutes(10));
    }

    public function getCreatedAtAttribute()
    {
        if($this->attributes['created_at'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at'] )->format('d/m/y H:i');
    }

    public function getCancelDateAttribute()
    {
        if($this->attributes['cancel_date'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['cancel_date'] )->format('d/m/y H:i');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['company'] ?? null, function ($query, $company){
            $query->whereHas('company', function($query) use ($company){
                $query->where('id',$company);
            });
        })->when($filters['event'] ?? null, function ($query, $event){
            $query->whereHas('event', function($query) use ($event){
                $query->where('id',$event);
            });
        });
    }



    
}
