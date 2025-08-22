<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        if (!User::where('email', 'admin@emisoras.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'email' => 'admin@emisoras.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Usuario administrador creado: admin@emisoras.com / admin123');
        }
        
        // Crear algunos usuarios de ejemplo
        $users = [
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@emisoras.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'María García',
                'email' => 'maria@emisoras.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
        ];
        
        foreach ($users as $userData) {
            if (!User::where('email', $userData['email'])->exists()) {
                User::create($userData);
            }
        }
        
        $this->command->info('Usuarios de ejemplo creados correctamente');
    }
}