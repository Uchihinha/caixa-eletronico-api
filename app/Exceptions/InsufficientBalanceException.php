<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
    public function __construct($message = 'Saldo insuficiente!')
    {
        parent::__construct($message, 422);
    }
}
