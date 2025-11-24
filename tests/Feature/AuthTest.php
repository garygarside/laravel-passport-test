<?php

namespace Tests\Feature;

use Illuminate\Support\Str;

$password = Str::password(16, true, true, true);

test('Tests that a new user can register successfully', function () use ($password) {
    $response = $this->postJson(route('api.register'), [
        'email' => 'test@example.com',
        'password' => $password,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure(['accessToken']);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

test('Tests that registration fails with invalid email format', function () use ($password) {
    $response = $this->postJson(route('api.register'), [
        'email' => 'invalid-email',
        'password' => $password,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('Tests that registration fails with weak password', function () {
    $response = $this->postJson(route('api.register'), [
        'email' => 'test2@example.com',
        'password' => 'tooshort',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

test('Tests that registration fails with duplicate email', function () use ($password) {
    // First successful registration
    $this->postJson(route('api.register'), [
        'email' => 'duplicate@example.com',
        'password' => $password,
    ])->assertStatus(201);

    // Attempt to register with the same email
    $response = $this->postJson(route('api.register'), [
        'email' => 'duplicate@example.com',
        'password' => $password,
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});
