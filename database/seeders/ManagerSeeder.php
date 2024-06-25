<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        $manager = new User();
        $manager->nama = 'Jek';
        $manager->email = 'jek@gmail.com';
        $manager->password = Hash::make('password');
        $manager->role = 'manager';
        $manager->save();
    }
}

