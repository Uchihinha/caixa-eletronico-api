<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_deposit()
    {
        $this->seed();

        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->post("api/users/accounts/$account->id/deposit", ['amount' => 10]);

        $response->assertStatus(201);
    }

    public function test_invalid_deposit()
    {
        $this->seed();

        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->post("api/users/accounts/$account->id/deposit", ['amount' => 0.5]);

        $response->assertStatus(422);
    }

    public function test_valid_withdraw()
    {
        $this->seed();

        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id, 'balance' => 100]);

        Passport::actingAs($user);

        $response = $this->post("api/users/accounts/$account->id/withdraw", ['amount' => 70]);

        $response->assertStatus(201);
    }

    public function test_invalid_withdraw()
    {
        $this->seed();

        $user = User::factory()->create();
        $account = Account::factory()->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->post("api/users/accounts/$account->id/withdraw", ['amount' => 0.5]);

        $response->assertStatus(422);
    }
}
