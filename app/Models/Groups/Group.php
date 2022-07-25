<?php

namespace App\Models\Groups;

use App\Models\Groups\GroupHasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group_has_users()
    {
        return $this->hasMany(GroupHasUser::class)->with('user');
    }
}
