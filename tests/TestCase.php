<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\CreatesApplication;

use function Pest\Laravel\artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        artisan('key:generate');
        artisan('migrate:fresh --force');
        artisan('passport:client', [
            '--personal' => true,
            '--name' => 'Mock PersonalTokenClient',
            '--provider' => 'users',
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
