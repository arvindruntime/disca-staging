<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
  
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'name'=>'Admin',
               'email'=>'admin@disca.com',
               'user_type'=>1,
               'password'=> bcrypt('Admin@123'),
            ],
            [
               'name'=>'Forum',
               'email'=>'forumuser@gmail.com',
               'user_type'=> 3,
               'account_type'=> 1,
               'password'=> bcrypt('Forum@123'),
            ],
            [
               'name'=>'Normal',
               'email'=>'user@gmail.com',
               'user_type'=>3,
               'password'=> bcrypt('User@123'),
            ],
            [
                'name'=>'Provider',
                'email'=>'provider@gmail.com',
                'user_type'=>2,
                'password'=> bcrypt('Provider@123'),
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}