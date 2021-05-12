<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::firstOrCreate([
            'id'    => 1,
            'role'  => 'user'
        ]);

        Role::firstOrCreate([
            'id'    => 2,
            'role'  => 'administrator'
        ]);
    }
}
