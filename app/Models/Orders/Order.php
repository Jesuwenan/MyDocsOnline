<?php

namespace App\Models\Orders;

use Carbon\Carbon;
use App\Models\Events\Event;
use App\Models\Companies\Company;
use App\Models\Events\EventHasProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'total'
    ];


    public function event(){
        return $this->belongsTo(Event::class,'event_id','id')->with('event_has_products');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id','id')->with('user');
    }

    public function order_has_event_products()
    {
        return $this->hasMany(OrderHasEventProduct::class,'order_id','id')->with('event_has_product');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['created_at'] )->format('d/m/y H:i');
    }


    public function getTotalAttribute()
    {
        $total = 0;

        foreach ($this->order_has_event_products as $order_has_event_product) 
        {
            $total = $total + ($order_has_event_product->quantity*$order_has_event_product->event_has_product->cost);
        }

        return $total;
    }

    public function scopeFilter($query, array $filters)
    {
       // dd($filters['event']);

        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereHas('company', function($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('event', function($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['event'] ?? null, function ($query, $event){
            //dd($event);
            $query->whereHas('event', function($query) use ($event){
                $query->where('id',$event);
            });
        });
        
    }

}
