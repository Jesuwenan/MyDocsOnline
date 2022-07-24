<?php

namespace App\Models\Companies;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Events\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Participants\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class,'company_id','id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class,'company_id','id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_has_companies', 'company_id', 'event_id');
    }

    public  static function companyListUrl()
    {
        return Storage::temporaryUrl('companies-list.xls',Carbon::now()->addMinutes(10));
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        });
    }
}
