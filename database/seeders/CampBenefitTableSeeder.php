<?php

namespace Database\Seeders;

use App\Models\CampBenefit;
use Illuminate\Database\Seeder;

class CampBenefitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $CampBenefits = [
            [
                'camps_id' => 1,
                'name' => 'Pro Techstack Kit'
            ],
            [
                'camps_id' => 1,
                'name' => 'iMac Pro 2021 & Display'
            ],
            [
                'camps_id' => 1,
                'name' => '1-1 Mentoring Program'
            ],
            [
                'camps_id' => 1,
                'name' => 'Final Project Certificate'
            ],
            [
                'camps_id' => 1,
                'name' => 'Offline Course Videos'
            ],
            [
                'camps_id' => 1,
                'name' => 'Future Job Opportinity'
            ],
            [
                'camps_id' => 1,
                'name' => 'Premium Design Kit'
            ],
            [
                'camps_id' => 1,
                'name' => 'Website Builder'
            ],
            [
                'camps_id' => 2,
                'name' => '1-1 Mentoring Program'
            ],
            [
                'camps_id' => 2,
                'name' => 'Final Project Certificate'
            ],
            [
                'camps_id' => 2,
                'name' => 'Offline Course Videos'
            ],
            [
                'camps_id' => 2,
                'name' => 'Offline Course Videos'
            ],
        ];

        foreach ($CampBenefits as $key => $campbenefit) {
            # code...
            CampBenefit::create($campbenefit);
        }
    }
}
