<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin_account = User::factory()->create([
            'name' => 'Auriel James Fernandez',
            'email' => 'aurieljames11@gmail.com',
        ]);
        $role = Role::create(['name' => 'admin']);
        $admin_account->assignRole($role);
    }
}
