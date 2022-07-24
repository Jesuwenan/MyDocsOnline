<?php

namespace Database\Seeders;

use App\Models\Events\Event;
use App\Models\Orders\Order;
use Illuminate\Database\Seeder;
use App\Models\Companies\Company;
use App\Models\Events\EventHasProduct;
use App\Models\Orders\OrderHasEventProduct;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = [
            [
                'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                'created_at' => '2022-03-30 21:09:07',
                'updated_at'  => '2022-03-30 21:09:07',
            ],
            [
                'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                'created_at' => '2022-03-31 06:59:11',
                'updated_at'  => '2022-03-31 06:59:11',
            ],
            [
                'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                'company_id'    =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                'created_at' => '2022-03-31 17:26:35',
                'updated_at'  => '2022-03-31 17:26:35',
            ],

        ];

        foreach ($orders as $order) {
            Order::create($order);
        }

        $order_has_event_products =  [
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Karting')->first()->id,
                'quantity' => 1,
                'created_at' => '2022-03-30 21:09:07',
                'updated_at'  => '2022-03-30 21:09:07',
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Petit déjeuner complémentaire')->first()->id,
                'quantity' => 10,
                'created_at' => '2022-03-30 21:09:07',
                'updated_at'  => '2022-03-30 21:09:07',
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','déjeuner complémentaire')->first()->id,
                'quantity' => 10,
                'created_at' => '2022-03-30 21:09:07',
                'updated_at'  => '2022-03-30 21:09:07',
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Bouteille de champagne')->first()->id,
                'quantity' => 0
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Karting')->first()->id,
                'quantity' => 2,
                'created_at' => '2022-03-31 06:59:11',
                'updated_at'  => '2022-03-31 06:59:11',
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Petit déjeuner complémentaire')->first()->id,
                'quantity' => 0,
                'created_at' => '2022-03-31 06:59:11',
                'updated_at'  => '2022-03-31 06:59:11',
            ],
            [
                'order_id' => Order::where([
                    'event_id'      => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','déjeuner complémentaire')->first()->id,
                'quantity' => 0,
                'created_at' => '2022-03-31 06:59:11',
                'updated_at'  => '2022-03-31 06:59:11',
            ],
            [
                'order_id' => Order::where([
                    'event_id'          => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'        =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Bouteille de champagne')->first()->id,
                'quantity' => 0,
                'created_at' => '2022-03-31 06:59:11',
                'updated_at'  => '2022-03-31 06:59:11',
            ],
            [
                'order_id' => Order::where([
                    'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Karting')->first()->id,
                'quantity' => 3,
                'created_at' => '2022-03-31 17:26:35',
                'updated_at'  => '2022-03-31 17:26:35',
            ],
            [
                'order_id' => Order::where([
                    'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Petit déjeuner complémentaire')->first()->id,
                'quantity' => 30
            ],
            [
                'order_id' => Order::where([
                    'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','déjeuner complémentaire')->first()->id,
                'quantity' => 50,
                'created_at' => '2022-03-31 17:26:35',
                'updated_at'  => '2022-03-31 17:26:35',
            ],
            [
                'order_id' => Order::where([
                    'event_id' => Event::where('name', 'Course de Karting 10 juin 2022')->first()->id,
                    'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                ])->first()->id,
                'event_has_product_id' => EventHasProduct::where('name','Bouteille de champagne')->first()->id,
                'quantity' => 15,
                'created_at' => '2022-03-31 17:26:35',
                'updated_at'  => '2022-03-31 17:26:35',
            ],
        ];

        foreach ($order_has_event_products as $order_has_event_product) {
            OrderHasEventProduct::create($order_has_event_product);
        }
    }
}
