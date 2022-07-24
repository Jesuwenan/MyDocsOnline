<?php

namespace App\Models\Events;

use Illuminate\Support\Carbon;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends  = [
        'status'
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'event_has_companies', 'event_id', 'company_id');
    }

    public function event_has_products(){
        return $this->hasMany(EventHasProduct::class,'event_id','id');
    }

    public function getEventDateAttribute()
    {
        if($this->attributes['event_date'])
            return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['event_date'] )->format('d/m/y H:i');
    }

    public function getStatusAttribute()
    {
        $next_min_event = (Event::where('event_date','>=',date('Y-m-d'))->min('event_date'));

        //dd($next_min_event);
        //dd(Carbon::createFromFormat('Y-m-d H:i:s',$next_min_event)->format('Y-m-d'));
       // dd(Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['event_date'])->format('Y-m-d'));
        $status  = 'Inactive';
        
        if($next_min_event) {

            if(Carbon::createFromFormat('Y-m-d H:i:s',$next_min_event)->format('Y-m-d')===Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['event_date'])->format('Y-m-d')){
                $status = 'In Progress';
            }else{
                if((strtotime($this->attributes['event_date'])-strtotime($next_min_event))>0){
                    $status = 'Active';
                }else{
                    if((strtotime($this->attributes['event_date'])-strtotime($next_min_event))<0){
                        $status = 'Inactive';
                    }
                }
            }
        }
        return $status;

    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

}
