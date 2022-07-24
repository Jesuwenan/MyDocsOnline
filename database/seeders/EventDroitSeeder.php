<?php

namespace Database\Seeders;

use App\Models\Events\Event;
use App\Models\Participants\EventDroit;
use Illuminate\Database\Seeder;

class EventDroitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $event_droits = [
            'Peut commander des produits SUPPLEMENTAIRES au bar',
            'Peut commander au bar'
        ];

        foreach ($event_droits as $event_droit) 
        {
            # code...
            EventDroit::create([
                'name'  =>  $event_droit
            ]);
        }
    }
}
