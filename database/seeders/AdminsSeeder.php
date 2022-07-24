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
        $company = Company::create([
            'name' => 'Charnoy',
            'address' => 'Admin',
            'city'  => 'Bruxelles',
            'postal_code' => '1234',
            'email' => 'admin@admin.com',
            'vat_number'    => 'BERRR343432'
        ]);
    
        $data = [

            [
                'email' => 'admin@facilesolution.com',
                // 'password' => Hash::make('tXcb_r6[uxXj_9~5'), 
                'password' => Hash::make('azertyui'),
                'is_admin'    => true,
                'company_id' => $company->id
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
