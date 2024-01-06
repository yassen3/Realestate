<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
         [
            'name'=> 'Admin',
            'username'=> 'admin',
            'email'=> 'admin@yahoo.com',
            'password'=> Hash::make('12345678'),
            'role'=> 'admin',
            'status'=> 'active',
        ],
        [
            'name'=> 'Agent',
            'username'=> 'agent',
            'email'=> 'agent@yahoo.com',
            'password'=> Hash::make('12345678'),
            'role'=> 'agent',
            'status'=> 'active',
        ],
        [
            'name'=> 'User',
            'username'=> 'user',
            'email'=> 'user@yahoo.com',
            'password'=> Hash::make('12345678'),
            'role'=> 'user',
            'status'=> 'active',
        ],
    ]);
    }
}