<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void 
    {
        User::create([
            'email' => 'azrielmp3@gmail.com',
            'username' => 'azrielmp',
            'role' => 'admin',
            'password' => Hash::make('123'),
        ]);
    }
}
