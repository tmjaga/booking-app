<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testLoginWithValidCredentials(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'user@mail.com',
            'password' => 'password'
        ]);

        $response->assertOk();
        $this->assertTrue(isset($response['api-token']));
    }


    public function testLoginWithInvalidCredentials(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'user@mail.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(422);
    }


}
