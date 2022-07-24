<?php

namespace App\Models\Orders;

use App\Models\Events\EventHasProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHasEventProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function event_has_product(){
        
        return $this->belongsTo(EventHasProduct::class,'event_has_product_id','id');
    }
}
