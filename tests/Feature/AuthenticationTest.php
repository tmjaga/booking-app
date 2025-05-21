<?php

use App\Models\Room;
use App\Models\User;

beforeEach(function () {
    $this->user = User::where('is_admin', false)->first();
    $this->room = Room::first();
    $this->token = $this->user->createToken('Test Token')->plainTextToken;
});

it('Login in with valid credentials', function () {
    $response = $this->postJson(route('login'), [
        'email' => 'user@mail.com',
        'password' => 'password',
    ]);

    expect($response)->assertOk()
        ->and($response['api-token'])
        ->toBeString();
});

it('Login in with invalid credentials', function () {

    $response = $this->postJson(route('login'), [
        'email' => 'invalid_user@mail.com',
        'password' => 'invalid_password',
    ]);

    expect($response->status())->toBe(422);
});

it('Logged user can logs out successfully', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->token,
    ])->post(route('logout'));

    expect($response)->assertOk()
        ->and($response->json('message'))
        ->toBe('Logged Out');

    // check tokens
    $tokens = $this->user->tokens()->get();
    expect($tokens)->toHaveCount(0);

    // fix sanctum issue with user logout in tests
    Auth::guard('sanctum')->forgetUser();

    $response = $this->withHeaders([
        'Authorization' => 'Bearer '.$this->token,
    ])->get(route('rooms'));

    expect($response->status())->toBe(403);
});
