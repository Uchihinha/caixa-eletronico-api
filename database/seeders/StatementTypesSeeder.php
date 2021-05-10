<?php

namespace Database\Seeders;

use App\Models\StatementType;
use Illuminate\Database\Seeder;

class StatementTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StatementType::firstOrCreate([
            'id'    => 1,
            'name'  => 'Depósito'
        ]);
        StatementType::firstOrCreate([
            'id'    => 2,
            'name'  => 'Saque'
        ]);
        StatementType::firstOrCreate([
            'id'    => 3,
            'name'  => 'Transferência'
        ]);
    }
}
