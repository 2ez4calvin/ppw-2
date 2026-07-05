<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'name'              => 'Admin',
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin'         => true,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
       
}

