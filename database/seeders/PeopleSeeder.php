<?php

namespace Database\Seeders;

use DateTime;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            // [
            //     'first_name' => 'Samuel',
            //     'last_name' => 'ZANNOU',
            //     'username' => 'Samfinder',
            //     'sexe' => 'Masculin',
            //     'email' => 'zsamuel737@gmail.com',
            //     'phone' => 91137630,
            //     'password' => Hash::make('azertyui'),
            // ],
            [
                'first_name' => 'Joel',
                'last_name' => 'ZANNOU',
                'username' => 'Joel',
                'sexe' => 'Masculin',
                'email' => 'jc@gmail.com',
                'phone' => 67928812,
                'password' => Hash::make('azertyui'),
            ],
            [
                'first_name' => 'Dara',
                'last_name' => 'Abimbola',
                'username' => 'Dara',
                'sexe' => 'Masculin',
                'email' => 'dara@gmail.com',
                'phone' => 91137631 ,
                'password' => Hash::make('azertyui'),
            ],
            [
                'first_name' => 'André',
                'last_name' => 'LOUSSIN',
                'username' => 'André',
                'sexe' => 'Masculin',
                'email' => 'andre@gmail.com',
                'phone' => 91137632,
                'password' => Hash::make('azertyui'),
            ],
            [
                'first_name' => 'Emmanuel',
                'last_name' => 'GBAVOU',
                'username' => 'Egbavou',
                'sexe' => 'Masculin',
                'email' => 'egbavou@gmail.com',
                'phone' => 91137635,
                'password' => Hash::make('azertyui'),
            ],
            [
                'first_name' => 'Judith',
                'last_name' => 'ZANNOU',
                'username' => 'Judith',
                'sexe' => 'Feminin',
                'email' => 'Judith@gmail.com',
                'phone' => 96788113,
                'password' => Hash::make('azertyui'),
            ],
            [
                'first_name' => 'Toto',
                'last_name' => 'KOSSI',
                'username' => 'KOTO',
                'sexe' => 'Masculin',
                'email' => 'koto@gmail.com',
                'phone' => 96788100,
                'password' => Hash::make('azertyui'),
            ]
            ];
        
            foreach($data as $row){
                User::firstOrCreate($row);
            };
          
    }
    

    
}
