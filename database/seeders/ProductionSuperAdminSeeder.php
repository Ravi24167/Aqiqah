<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class ProductionSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = trim((string) env('SUPERADMIN_EMAIL'));
        $password = (string) env('SUPERADMIN_PASSWORD');
        $name = trim((string) env('SUPERADMIN_NAME', 'Super Admin'));

        if ($email === '' || $password === '') {
            throw new RuntimeException(
                'Set SUPERADMIN_EMAIL and SUPERADMIN_PASSWORD before creating the production super admin.'
            );
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name !== '' ? $name : 'Super Admin',
                'password' => Hash::make($password),
                'role' => 'super_admin',
                'is_approved' => true,
            ]
        );
    }
}
