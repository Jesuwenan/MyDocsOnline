<?php

namespace Database\Seeders;

use App\Models\Document\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'nom' => "Science"
            ],
            [
                'nom' => "Administration"
            ],
            [
                'nom' => "Personnel"
            ],
            [
                'nom' => "Littéraire"
            ]
        ];

        foreach ($data as $row){
            $category = Category::firstOrCreate($row);
        }
    }
}
