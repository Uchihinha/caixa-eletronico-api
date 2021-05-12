<?php

namespace Tests\Unit;

use App\Exceptions\InsufficientBalanceException;
use App\Models\Account;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccountBalanceTest extends TestCase
{
    public function test_insufficient_account_balance_validation()
    {
        $this->expectException(InsufficientBalanceException::class);

        $account = Account::factory()->make(['balance' => 0]);

        $account->validateBalance(1);
    }

    public function test_sufficient_account_balance_validation()
    {
        $account = Account::factory()->make(['balance' => 10]);

        $this->assertNull($account->validateBalance(9));
    }
}
