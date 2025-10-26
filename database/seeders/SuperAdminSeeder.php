<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('SUPER_ADMIN_EMAIL');
        $password = env('SUPER_ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('SUPER_ADMIN_EMAIL atau SUPER_ADMIN_PASSWORD belum diset; melewati SuperAdminSeeder.');

            return;
        }

        $name = env('SUPER_ADMIN_NAME', 'Grand Tamansari Admin');
        $username = env('SUPER_ADMIN_USERNAME', Str::slug($name, '_'));

        User::withTrashed()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'username' => $username,
                'password' => Hash::make($password),
                'role' => UserRole::SUPER_ADMIN,
                'email_verified_at' => now(),
                'deleted_at' => null,
            ]
        );
    }
}
