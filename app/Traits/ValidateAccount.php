<?php
namespace App\Traits;

use App\Exceptions\InsufficientBalanceException;

trait ValidateAccount
{
    public function validateBalance(float $amount) {
        if ($this->balance < $amount) throw new InsufficientBalanceException("Saldo insuficiente!", 422);
    }

}
