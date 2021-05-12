<?php

use App\Exceptions\InsufficientMoneyBillsException;

if (!function_exists('validateMoneyBill')) {
    function validateMoneyBill(float $amount) {
        $availableNotes = [100, 50, 20];
        $remainder = $amount;

        $data = [];

        foreach ($availableNotes as $key => $note) {
            $data[$note] = intdiv($remainder, $note);
            $remainder = $remainder % $note;
        }

        if ($remainder) throw new InsufficientMoneyBillsException();

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
