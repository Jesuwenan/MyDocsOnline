<?php

namespace Database\Seeders;

use App\Models\Events\Event;
use App\Models\Events\EventHasProduct;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $event = Event::create([
            'id' => 6,
            'name'  => 'Course de Karting 10 juin 2022',
            'event_date'  =>  '2022-06-11 12:00:00',
            'created_at'  => '2022-03-29 15:50:04',
            'updated_at'  => '2022-03-29 15:53:20'
        ]);

        $event_has_products = [
            [
                'event_id' => $event->id,
                'name'  => 'Karting',
                'cost'  => 1000.00,
                'created_at'  => '2022-03-29 15:53:20',
                'updated_at'  => '2022-03-29 15:53:20'
            ],
            [
                'event_id' => $event->id,
                'name'  => 'Petit déjeuner complémentaire',
                'cost'  => 12.00,
                'created_at'  => '2022-03-29 15:53:20',
                'updated_at'  => '2022-03-29 15:53:20'
            ],
            [
                'event_id' => $event->id,
                'name'  => 'déjeuner complémentaire',
                'cost'  => 60.00,
                'created_at'  => '2022-03-29 15:53:20',
                'updated_at'  => '2022-03-29 15:53:20'
            ],
            [
                'event_id' => $event->id,
                'name'  => 'Bouteille de champagne',
                'cost'  => 55.00,
                'created_at'  => '2022-03-29 15:53:20',
                'updated_at'  => '2022-03-29 15:53:20'
            ],
        ];

        foreach ($event_has_products as $event_has_product) {
            EventHasProduct::create($event_has_product);
        }
    }
}
