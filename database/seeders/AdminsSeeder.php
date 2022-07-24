<?php

namespace Database\Seeders;

use App\Models\Companies\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
        $company = Company::create([
            'name' => 'Charnoy',
            'address' => 'Admin',
            'city'  => 'Bruxelles',
            'postal_code' => '1234',
            'email' => 'admin@admin.com',
            'vat_number'    => 'BERRR343432'
        ]);
    
=======
        
>>>>>>> 9e02e8431eb65b27c4c3346bf8f50f2dec0caef7
        $data = [

            [
                'email' => 'admin@facilesolution.com',
                // 'password' => Hash::make('tXcb_r6[uxXj_9~5'), 
                'password' => Hash::make('azertyui'),
                'is_admin'    => true
            ],
        ];
        
        $permissions = Permission::all();

        foreach ($data as $row) {
            $user = User::firstOrCreate($row);
            
            foreach ($permissions as $permission) {
                if ($user && $permission) {
                    $user->givePermissionTo($permission);
                }
            }
        }
    }
}
