<?php

namespace App\Models\Document;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentShared extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function document() {

        return $this->belongsTo(Document::class,'document_id');
    }

    public function user() {

        return $this->belongsTo(User::class, 'user_id');
    }
}
