<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe_has_member extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function groupe() {

        $this->belongsTo(Groupe::class,'group_id');
    }

    public function user() {

        $this->hasMany(User::class,'user_id');
    }
}
