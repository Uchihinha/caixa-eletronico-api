<?php

namespace App\Exceptions;

use Exception;

class InsufficientMoneyBillsException extends Exception
{
    //
    public function __construct($message = 'Não há notas suficientes para a sua solicitação!')
    {
        parent::__construct($message, 422);
    }
}
