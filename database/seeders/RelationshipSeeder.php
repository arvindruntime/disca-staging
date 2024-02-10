<?php

namespace Database\Seeders;

use App\Models\RelationshipModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $relationship = [
            [
               'user_id'=>1,
               'name' => 'Family',
            ],
        ];
    
        foreach ($relationship as $key => $relation) {
            RelationshipModel::create($relation);
        }
    }
}
