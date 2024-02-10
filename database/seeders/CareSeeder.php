<?php

namespace Database\Seeders;

use App\Models\Care;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cares = [
            [
               'user_id'=>1,
               'name' => 'Care home',
            ],
            [
                'user_id'=>1,
                'name' => 'Day Care $ Domiciliary',
             ],
        ];
    
        foreach ($cares as $key => $care) {
            Care::create($care);
        }
    }
}
