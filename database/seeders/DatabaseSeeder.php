<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MasterAdminSeeder::class,
            LayananSeeder::class,
            VoucherSeeder::class,
        ]);

        // Akun demo (Fathir) — updateOrCreate biar db:seed aman diulang
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'admin2',
                'username' => 'admin2',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin2'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@test.com'],
            [
                'name' => 'notadmin',
                'username' => 'notadmin',
                'email' => 'user@test.com',
                'password' => Hash::make('notadmin'),
                'role' => 'user',
            ]
        );
    }
}