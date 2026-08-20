<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = Role::firstOrCreate(['name' => 'administrator']);
        $author = Role::firstOrCreate(['name' => 'author']);
        $sub    = Role::firstOrCreate(['name' => 'subscriber']);

        $password = env('SEED_ADMIN_PASSWORD') ?: Str::random(16);

        $user = User::updateOrCreate(
            ['email' => 'fpkfaculty@gmail.com'],
            [
                'name'      => 'FpKucas-Admin',
                'password'  => Hash::make($password),
                'role_id'   => $admin->id,
                'is_active' => 1,
            ]
        );
        $this->command->info("Admin email: {$user->email}");  
        $this->command->info("Password: {$password}");
    }
}