<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User;
        $admin->name = 'admin';
        $admin->email = 'admin@mail.com';
        $admin->password = Hash::make('password');
        $admin->role = 'admin';
        $admin->save();

        $agent = new User;
        $agent->name = 'agent';
        $agent->email = 'agent@mail.com';
        $agent->password = Hash::make('password');
        $agent->role = 'agent';
        $agent->save();
    }
}
