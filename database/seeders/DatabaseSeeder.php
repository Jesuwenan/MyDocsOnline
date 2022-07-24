<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\AdminsSeeder;
use Database\Seeders\PeopleSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EventDroitSeeder;
use Database\Seeders\PermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsSeeder::class,
            AdminsSeeder::class,
            CategorySeeder::class,
            DocumentSeeder::class,
            GroupSeeder::class,
            PeopleSeeder::class,

            // EventSeeder::class,
            // CompanySeeder::class,
            // OrderSeeder::class,
            // EventDroitSeeder::class
        ]);
    }
}
