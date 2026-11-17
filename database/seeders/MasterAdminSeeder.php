<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class MasterAdminSeeder extends Seeder
{
    public function run(): void
    {
        $username = config('master_admin.username');
        $email = config('master_admin.email');
        $password = config('master_admin.password');

        if (! is_string($username) || $username === '') {
            throw new RuntimeException('Atur MASTER_ADMIN_USERNAME sebelum menjalankan seeder.');
        }

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException('Atur MASTER_ADMIN_EMAIL yang valid sebelum menjalankan seeder.');
        }

        if (! is_string($password) || $password === '') {
            throw new RuntimeException('Atur MASTER_ADMIN_PASSWORD sebelum menjalankan seeder.');
        }

        $user = User::firstOrNew(['username' => $username]);
        $user->name = config('master_admin.name');
        $user->email = $email;
        $user->password = $password;
        $user->role = User::ROLE_MASTER_ADMIN;
        $user->save();
    }
}
