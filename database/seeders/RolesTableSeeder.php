<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $roles = [
        ['name' => 'admin', 'description' => 'Administrador del sistema'],
        ['name' => 'psychologist', 'description' => 'Psicólogo institucional'],
        ['name' => 'student', 'description' => 'Estudiante']
    ];

       foreach ($roles as $role) {
        Role::create($role);
    }
     // Crear usuario admin por defecto
    $admin = User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin')
    ]);

     $student = User::create([
        'name' => 'Student',
        'email' => 'estudiante@example.com',
        'password' => Hash::make('estudiante')
    ]);

      $psychologist = User::create([
        'name' => 'Psychologist',
        'email' => 'psicologo@example.com',
        'password' => Hash::make('psicologo')
    ]);

    $psychologist->roles()->attach(Role::where('name','psychologist')->first());
        $admin->roles()->attach(Role::where('name', 'admin')->first());
         $student->roles()->attach(Role::where('name', 'student')->first());
    }
}
