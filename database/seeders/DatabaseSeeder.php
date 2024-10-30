<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear el rol "Admin" si no existe
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
        ]);

        // Crear el usuario "admin" con el rol "Admin"
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin'), // Encripta la contraseña
            'role_id' => $adminRole->id,
        ]);
    }
}
