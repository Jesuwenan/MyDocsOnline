<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Companies\Company;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $row = 0;
        // if (($handle = fopen(base_path()."/public/companies_list.csv", "r")) !== FALSE) {
        //     while (($data = fgetcsv($handle, 0, ",",'"')) !== FALSE) {

        //         if($row!=0){
        //             //dd($row ,$data);

        //             if($row == 115)
        //             break;
                    
        //             if($this->validateEmail($data[7])){
        //                 if(!Company::where('email',$data[7])->first() && !User::where('email',$data[7])->first())
        //                 {
        //                    // $password = generatePassword();

        //                     $company = Company::create([
        //                         'name'      => $data[1],
        //                         'address'   => $data[2],
        //                         'postal_code' => $data[3],
        //                         'city' => $data[4],
        //                         'vat_number' => $data[5],
        //                         'email'  => $data[7]
        //                     ]);

        //                     User::create([
        //                         'company_id'    =>  $company->id,
        //                         'email'         =>  $data[7],
        //                         'password'      =>  $data[8]
        //                     ]);

        //                 }
        //             }
        //         }
                    
        //         $row++;
        //     }
        //     fclose($handle);
        // }

        $companies  = [
            [
                'name'      => 'ELECTRICITE TEIRLIJNCK  SPRL',
                'address'   => 'Rue Pinsonhaie',
                'postal_code' => 5070,
                'city' => 'Fosses-la-Ville',
                'vat_number' => 'BE0870.743.759',
                'email'  => 'info@teirlijnck.be',
                'manager' => 'Teirlilnck rudi',
                'manager_gsm' => '+32475820243',
                'created_at' => '2021-09-10 11:21:40',
                'updated_at' => '2022-03-30 21:09:07'
            ],
            [
                'name'      => 'MC&S',
                'address'   => 'vital Françoisse, 220/hall 12',
                'postal_code' => 6001,
                'city' => 'Marcinelle',
                'vat_number' => 'BE0899.588.985',
                'email'  => 'm.crestani@metal-concept-stabilite.be',
                'manager' => 'MICHEL CRESTANI',
                'manager_gsm' => '+32488222012',
                'created_at' => '2021-10-19 10:20:05',
                'updated_at' => '2021-10-19 10:20:05'
            ],
            [
                'name'      => 'SA Bemat',
                'address'   => 'Rue du Rond Point',
                'postal_code' => 6060,
                'city' => 'Charleroi',
                'vat_number' => 'BE0402.375.301',
                'email'  => 'dbaleriaux@bemat.be',
                'manager' => 'Baleriaux',
                'manager_gsm' => '+32485557282',
                'created_at' => '2021-11-08 10:45:36',
                'updated_at' => '2021-11-08 10:45:36'
            ]
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }

        $users = [
            [
                'company_id'    =>  Company::where('email','info@teirlijnck.be')->first()->id,
                'email'         =>  'info@teirlijnck.be',
                'password'      =>  '$2y$10$v2GzdiilzM/2/Q644GAZgOY8fjmU4sCsVn7JCwYyNLhTS7ZquyHVy',
                'created_at'    =>  '2021-09-10 11:21:40',
                'updated_at'    =>  '2022-03-30 21:09:07'
            ],
            [
                'company_id'    =>  Company::where('email','m.crestani@metal-concept-stabilite.be')->first()->id,
                'email'         =>  'm.crestani@metal-concept-stabilite.be',
                'password'      =>  '$2y$10$011zXj0ZBJBERNdRodSnKuL9A5qxLZ9xCm9hwaPvv6R0OEPiZ5r2G',
                'created_at'    =>  '2021-10-19 10:20:05',
                'updated_at'    =>  '2022-03-31 17:26:35'
            ],
            [
                'company_id'    =>  Company::where('email','dbaleriaux@bemat.be')->first()->id,
                'email'         =>  'dbaleriaux@bemat.be',
                'password'      =>  '$2y$10$SZsTU4fQVXq6mIluXKujNefDeyABPo6XvhBm0cxTGf8CIk7XkOwZC',
                'created_at'    =>  '2021-11-08 10:45:36',
                'updated_at'    =>  '2022-03-31 06:59:11'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
        
    }

    public function validateEmail($email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        else {
            return false;
        }
    }
}
