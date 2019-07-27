<?php

use Illuminate\Database\Seeder;

use App\User;

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user=User::where('email','badcoder@gmail.com')->first();

        if(!$user){
            User::create([
                'name'=>'John Doe',
                'email'=>'badcoder@gmail.com',
                'role'=>'admin',
                'password'=>Hash::make('password')
            ]);

            User::create([
                'name'=>'Jane Doe',
                'email'=>'goodcoder@gmail.com',
                'role'=>'admin',
                'password'=>Hash::make('password')
            ]);


        }
    }
}
