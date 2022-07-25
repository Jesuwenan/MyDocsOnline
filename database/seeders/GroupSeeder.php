<?php

namespace Database\Seeders;

use App\Models\Document\Groupe;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'group_name' => 'Mes amis'
            ],
            [
                'user_id' => 1,
                'group_name' => 'Famille ZANNOU'
            ],
            [
                'user_id' => 1,
                'group_name' => 'Famille AGOSSOU'
            ],
            [
                'user_id' => 1,
                'group_name' => 'Travail de groupe'
            ],

            
        ];
        foreach ($data as $row){
            $document = Groupe::firstOrCreate($row);
        }
        
    }
}
