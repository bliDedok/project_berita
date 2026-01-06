<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminEmail = 'admin@berita.com';

        $admin = User::firstOrNew(['email' => $adminEmail]);

        $admin->name = 'Admin';
        $admin->password = Hash::make('12345678');
        $admin->role = 'admin';
        $admin->save();
    }
}
