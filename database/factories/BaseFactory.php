<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BaseFactory extends Factory
{
    public function randomDate() {
        $int = rand(1262055681,1362055681);
        $date = date("Y-m-d",$int);

        return $date;
    }

    public function definition() {
        //
    }
}
