<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::whereName('admin')->first();

        User::factory()->for($adminRole)->create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'phone' => '5555551234'
        ]);
    }
}
