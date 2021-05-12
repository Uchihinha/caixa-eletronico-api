<?php

namespace Tests\Unit;

use App\Exceptions\InsufficientMoneyBillsException;
use PHPUnit\Framework\TestCase;

class MoneyBillsTest extends TestCase
{
    public function test_120_money_bills_format()
    {
        $amount = 120;
        $validate = validateMoneyBill($amount);

        $this->assertEquals([
            100 => 1,
            50 => 0,
            20 => 1
        ], $validate);
    }

    public function test_100_money_bills_format()
    {
        $amount = 100;
        $validate = validateMoneyBill($amount);

        $this->assertEquals([
            100 => 1,
            50 => 0,
            20 => 0
        ], $validate);
    }

    public function test_70_money_bills_format()
    {
        $amount = 70;
        $validate = validateMoneyBill($amount);

        $this->assertEquals([
            100 => 0,
            50 => 1,
            20 => 1
        ], $validate);
    }

    public function test_20_money_bills_format()
    {
        $amount = 20;
        $validate = validateMoneyBill($amount);

        $this->assertEquals([
            100 => 0,
            50 => 0,
            20 => 1
        ], $validate);
    }

    public function test_exception_money_bills_format()
    {
        $this->expectException(InsufficientMoneyBillsException::class);

        $amount = 10;
        validateMoneyBill($amount);
    }
}
