<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AccountType::firstOrCreate([
            'id'    => 1,
            'name'      => 'Poupança'
        ]);

        AccountType::firstOrCreate([
            'id'    => 2,
            'name'      => 'Corrente'
        ]);
    }
}
