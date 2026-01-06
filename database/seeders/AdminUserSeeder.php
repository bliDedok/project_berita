<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'admin@berita.com';

        $admin = User::firstOrNew(['email' => $adminEmail]);

        $admin->name = 'Admin';
        $admin->password = Hash::make('12345678');
        $admin->role = 'admin';
        $admin->save();
    }
}
