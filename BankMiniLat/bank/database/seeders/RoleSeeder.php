<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);
        $tellerRole = Role::firstOrCreate(['name' => 'teller']);
        $nasRole    = Role::firstOrCreate(['name' => 'nasabah']);

        // default admin
        User::firstOrCreate(['email' => 'admin@bankmini.test'], [
            'name' => 'Admin BankMini',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);
    }
}
