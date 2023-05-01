<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'Admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Manager',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'User',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
