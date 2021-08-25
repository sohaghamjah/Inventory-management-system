<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'role_name' => 'Super Admin',
                'deletable' => 1,
            ],
            [
                'role_name' => 'Admin',
                'deletable' => 1,
            ],
        ]);
    }
}
