<?php

namespace Database\Seeders;

use App\Models\Events\Event;
use App\Models\Orders\Order;
use App\Models\People\Person;
use Illuminate\Database\Seeder;
use App\Models\Companies\Company;
use App\Models\Consummation\Consummation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\Participants\Participant;

class BackupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //dd(base_path());
        DB::unprepared(File::get(base_path().'/public/mysql-charnoy.sql'));

        // $event = Event::where('name','Course de Karting 10 juin 2022')->first();

        // $company_ids = Order::where('event_id',$event->id)->pluck('company_id')->toArray();

        // Company::whereNotIn('id',$company_ids)->delete();

        // Order::where('event_id',$event->id)->delete();

        // Participant::where('event_id',$event->id)->delete();

        // Person::destroy(Person::pluck('id')->toArray);

        // Consummation::destroy(Consummation::pluck('id')->toArray);
    }
}
