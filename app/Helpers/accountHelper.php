<?php

use Symfony\Component\HttpKernel\Exception\HttpException;

if (!function_exists('validateMoneyBill')) {
    function validateMoneyBill(float $amount) {
        $availableNotes = [100, 50, 20];
        $remainder = $amount;

        $data = [];

        foreach ($availableNotes as $key => $note) {
            $data[$note] = intdiv($remainder, $note);
            $remainder = $remainder % $note;
        }

        if ($remainder) throw new HttpException(422, 'Não há notas suficientes para a sua solicitação!');

        return $data;
    }
}

if (!function_exists('formatWithdrawResponse')) {
    function formatWithdrawResponse(array $moneyBills) {
        $message = 'Sucesso! O saque será enviado para a fila de transação. Composto por:';
        $comma = '';

        foreach ($moneyBills as $key => $value) {
            $message .= "$comma $value nota(s) de R$ $key";
            $comma = ',';
        }

        return $message;
    }
}
