<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\SparePart;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
});

it('can fetch inventory index', function () {
    $response = $this->actingAs($this->admin)->get('/inventory');
    $response->assertStatus(200);
});

it('can create a new spare part', function () {
    $category = Category::factory()->create();
    $location = Location::factory()->create();

    $response = $this->actingAs($this->admin)->post('/inventory', [
        'category_id' => $category->id,
        'brand' => 'BrandX',
        'type' => 'TypeY',
        'inventory_number' => 'INV-12345',
        'serial_number' => 'SN-99999',
        'condition' => 'Normal',
        'location_id' => $location->id,
        'specification' => 'Spesifikasi test',
        'status' => 'aktif',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('spare_parts', [
        'inventory_number' => 'INV-12345',
        'brand' => 'BrandX',
    ]);
});

it('validates required fields when creating spare part', function () {
    $response = $this->actingAs($this->admin)->post('/inventory', []);

    $response->assertSessionHasErrors(['category_id', 'location_id', 'condition']);
});

it('can update an existing spare part', function () {
    $sparePart = SparePart::factory()->create([
        'brand' => 'Old Brand',
    ]);
    
    $category = Category::factory()->create();
    $location = Location::factory()->create();

    $response = $this->actingAs($this->admin)->put("/inventory/{$sparePart->id}", [
        'category_id' => $category->id,
        'brand' => 'New Brand',
        'type' => 'New Type',
        'inventory_number' => $sparePart->inventory_number,
        'condition' => 'Perbaikan',
        'location_id' => $location->id,
        'status' => 'aktif',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('spare_parts', [
        'id' => $sparePart->id,
        'brand' => 'New Brand',
        'condition' => 'Perbaikan'
    ]);
});

it('can delete a spare part', function () {
    $sparePart = SparePart::factory()->create();

    $response = $this->actingAs($this->admin)->delete("/inventory/{$sparePart->id}");

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('spare_parts', [
        'id' => $sparePart->id,
    ]);
});
