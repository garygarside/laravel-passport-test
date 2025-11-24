<?php

namespace Tests\Unit;

use App\Enums\TransactionType;
use App\Models\Account;
use App\Models\User;

test('Tests that a user can create an account', function () {
    $user = User::factory()->create();
    $account = $user->accounts()->create();

    $this->assertNotNull($account);
    $this->assertEquals($user->id, $account->user_id);
    $this->assertEquals(0, $account->balance);
    $this->assertDatabaseHas('accounts', [
        'user_id' => $user->id,
        'balance' => 0,
    ]);
});

test('Tests that an account can have multiple transactions', function () {
    $account = Account::factory()->create();

    $account->transactions()->create([
        'type' => TransactionType::DEPOSIT,
        'amount' => 500,
    ]);
    $account->transactions()->create([
        'type' => TransactionType::WITHDRAWAL,
        'amount' => 200,
    ]);

    $account->refresh();

    $this->assertCount(2, $account->transactions);
    $this->assertDatabaseCount('transactions', 2);
});

test('Tests that account balance updates after deposits', function () {
    $account = Account::factory()->create(['balance' => 0]);

    $account->transactions()->create([
        'type' => TransactionType::DEPOSIT,
        'amount' => 500,
    ]);

    $account->refresh(); // Reload the account to get the updated balance
    $this->assertEquals(500, $account->balance);

    $account->transactions()->create([
        'type' => TransactionType::DEPOSIT,
        'amount' => 250,
    ]);

    $account->refresh();
    $this->assertEquals(750, $account->balance);
});

test('Tests that account balance updates after withdrawals', function () {
    $account = Account::factory()->create();

    $account->transactions()->create([
        'type' => TransactionType::DEPOSIT,
        'amount' => 300,
    ]);

    $account->refresh();
    $this->assertEquals(300, $account->balance);

    $account->transactions()->create([
        'type' => TransactionType::WITHDRAWAL,
        'amount' => 150,
    ]);

    $account->refresh();
    $this->assertEquals(150, $account->balance);
});

test('Tests that account cannot withdraw more than available funds', function () {
    $account = Account::factory()->create(['balance' => 500]);

    $this->assertFalse($account->canWithdraw(600));
    $this->assertTrue($account->canWithdraw(500));
    $this->assertTrue($account->canWithdraw(400));
});
