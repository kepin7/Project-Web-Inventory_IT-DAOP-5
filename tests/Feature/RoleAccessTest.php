<?php

use App\Models\User;

it('allows super_admin to access management routes', function () {
    $superAdmin = User::factory()->create([
        'role' => 'super_admin',
        'is_active' => true,
    ]);

    $this->actingAs($superAdmin)
        ->get('/management/users')
        ->assertStatus(200);

    $this->actingAs($superAdmin)
        ->get('/management/category')
        ->assertStatus(200);

    $this->actingAs($superAdmin)
        ->get('/management/locations')
        ->assertStatus(200);
});

it('prevents admin from accessing management routes', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $this->actingAs($admin)
        ->get('/management/users')
        ->assertRedirect('/');

    $this->actingAs($admin)
        ->get('/management/category')
        ->assertRedirect('/');
});

it('allows admin and super_admin to access inventory and stock movement', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
    ]);

    $superAdmin = User::factory()->create([
        'role' => 'super_admin',
        'is_active' => true,
    ]);

    $this->actingAs($admin)->get('/inventory')->assertStatus(200);
    $this->actingAs($superAdmin)->get('/inventory')->assertStatus(200);

    $this->actingAs($admin)->get('/stock-movement')->assertStatus(200);
    $this->actingAs($superAdmin)->get('/stock-movement')->assertStatus(200);
});

it('redirects unauthenticated users to login for protected routes', function () {
    $this->get('/inventory')->assertRedirect('/login');
    $this->get('/management/users')->assertRedirect('/login');
});
