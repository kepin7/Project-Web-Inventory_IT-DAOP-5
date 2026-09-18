<?php

use App\Models\User;
use App\Mail\MagicLoginMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

it('displays the login page', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

it('sends magic link for valid and active email', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'is_active' => true,
    ]);

    $response = $this->post('/login', ['email' => 'test@example.com']);
    
    $response->assertRedirect();
    $response->assertSessionHas('success');
    
    Mail::assertSent(MagicLoginMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
    
    $this->assertNotNull($user->fresh()->login_token);
});

it('does not send magic link for invalid email but returns same success message', function () {
    Mail::fake();

    $response = $this->post('/login', ['email' => 'notfound@example.com']);
    
    $response->assertRedirect();
    $response->assertSessionHas('success');
    
    Mail::assertNothingSent();
});

it('does not send magic link for inactive user', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'inactive@example.com',
        'is_active' => false,
    ]);

    $response = $this->post('/login', ['email' => 'inactive@example.com']);
    
    $response->assertRedirect();
    $response->assertSessionHas('success');
    
    Mail::assertNothingSent();
    $this->assertNull($user->fresh()->login_token);
});

it('logs in user with valid token', function () {
    $user = User::factory()->create([
        'is_active' => true,
        'login_token' => 'valid-token-123',
        'login_token_expires_at' => now()->addMinutes(15),
    ]);

    $response = $this->get('/verify-login/valid-token-123');
    
    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
    
    $user->refresh();
    $this->assertNull($user->login_token);
    $this->assertNull($user->login_token_expires_at);
    $this->assertNotNull($user->last_login_at);
});

it('fails to log in with expired token', function () {
    $user = User::factory()->create([
        'is_active' => true,
        'login_token' => 'expired-token-123',
        'login_token_expires_at' => now()->subMinutes(5),
    ]);

    $response = $this->get('/verify-login/expired-token-123');
    
    $response->assertRedirect('/login');
    $response->assertSessionHas('error');
    $this->assertGuest();
});

it('fails to log in if user becomes inactive before clicking link', function () {
    $user = User::factory()->create([
        'is_active' => false,
        'login_token' => 'valid-token-but-inactive',
        'login_token_expires_at' => now()->addMinutes(15),
    ]);

    $response = $this->get('/verify-login/valid-token-but-inactive');
    
    $response->assertRedirect('/login');
    $response->assertSessionHas('error');
    $this->assertGuest();
});
