<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (!$email || !$password) {
            return;
        }

        $admin = User::firstOrNew(['email' => $email]);
        $isNewAdmin = !$admin->exists;

        $admin->name = env('ADMIN_NAME', $admin->name ?: 'Administrador');
        $admin->is_admin = true;
        $admin->email_verified_at ??= now();

        if ($isNewAdmin || env('ADMIN_RESET_PASSWORD', false)) {
            $admin->password = $password;
        }

        $admin->save();
    }
}