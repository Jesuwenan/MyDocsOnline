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
<<<<<<< HEAD
            CategorySeeder::class,
            DocumentSeeder::class,
            GroupSeeder::class,
            PeopleSeeder::class,

            // EventSeeder::class,
            // CompanySeeder::class,
            // OrderSeeder::class,
            // EventDroitSeeder::class
=======
>>>>>>> 9e02e8431eb65b27c4c3346bf8f50f2dec0caef7
        ]);
    }
}
