<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [

            'name' => 'admin',
            'email'=> 'admin@kamponginggrispare.com',
            'role'=> 'admin',
            'password'=> bcrypt('adminkip2025'),


            ],
            [

            'name' => 'mentor',
            'email'=> 'mentor@kamponginggrispare.com',
            'role'=> 'mentor',
            'password'=> bcrypt('mentorkip2025'),


            ],
            [

            'name' => 'student',
            'email'=> 'student@kamponginggrispare.com',
            'role'=> 'student',
            'password'=> bcrypt('studentkip2025'),


            ],
        ];

        foreach($userData as $key => $val){
        User::create($val);
        }
    }

}
