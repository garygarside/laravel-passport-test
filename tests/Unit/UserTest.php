<?php

namespace Tests\Unit;

use App\Models\User;
use Laravel\Passport\Passport;

test('Tests that a new user can register successfully', function () {
    $user = User::factory()->create();

    $this->assertNotNull($user);
    $this->assertDatabaseHas('users', ['email' => $user->email]);
});

test('Tests that a user can create a personal access token', function () {
    $user = User::factory()->create();
    Passport::actingAs($user, ['TestToken']);

    $token = $user->createToken('TestToken');

    $this->assertNotNull($token->accessToken);
    $this->assertDatabaseHas('oauth_access_tokens', [
        'user_id' => $user->id,
        'name' => 'TestToken',
    ]);
});
