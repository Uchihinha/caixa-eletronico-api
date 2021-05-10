<?php
namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\HttpException;

trait ValidateAccount
{
    public function validateBalance(float $amount) {
        if ($this->balance < $amount) throw new HttpException(422, "Saldo insuficiente!");
    }

}
