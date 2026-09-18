<?php

use App\Models\User;
use App\Models\SparePart;
use App\Models\Location;
use App\Models\Category;
use App\Models\StockMovement;
use App\Models\Activity;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
});

it('can fetch stock movement index', function () {
    $response = $this->actingAs($this->admin)->get('/stock-movement');
    $response->assertStatus(200);
});

it('creates stock in movement and updates availability and condition', function () {
    $category = Category::factory()->create();
    $sparePart = SparePart::factory()->create([
        'category_id' => $category->id,
        'is_available' => false, // Initially borrowed
        'condition' => 'Rusak'
    ]);
    $location = Location::factory()->create();

    $response = $this->actingAs($this->admin)->post('/stock-movement', [
        'type' => 'in',
        'pic_name' => 'John Doe',
        'date' => now()->format('Y-m-d H:i:s'),
        'condition' => 'Normal',
        'location_id' => $location->id,
        'spare_part_ids' => [$sparePart->id],
        'notes' => 'Telah diperbaiki dan dikembalikan',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Assert movement was recorded
    $this->assertDatabaseHas('stock_movements', [
        'spare_part_id' => $sparePart->id,
        'type' => 'in',
        'condition' => 'Normal',
        'location_id' => $location->id,
    ]);

    // Assert spare part condition and availability updated
    $this->assertDatabaseHas('spare_parts', [
        'id' => $sparePart->id,
        'is_available' => true,
        'condition' => 'Normal'
    ]);
    
    // Assert activity log was created
    $this->assertDatabaseHas('activities', [
        'action' => 'stock_in',
        'category_id' => $category->id,
    ]);
});

it('creates stock out movement and updates availability', function () {
    $category = Category::factory()->create();
    $sparePart = SparePart::factory()->create([
        'category_id' => $category->id,
        'is_available' => true, 
        'condition' => 'Normal'
    ]);

    $response = $this->actingAs($this->admin)->post('/stock-movement', [
        'type' => 'out',
        'pic_name' => 'Jane Smith',
        'date' => now()->format('Y-m-d H:i:s'),
        'destination' => 'Stasiun Purwokerto',
        'spare_part_ids' => [$sparePart->id],
        'notes' => 'Dipinjam untuk perbaikan wesel',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Assert movement was recorded
    $this->assertDatabaseHas('stock_movements', [
        'spare_part_id' => $sparePart->id,
        'type' => 'out',
        'destination' => 'Stasiun Purwokerto',
    ]);

    // Assert spare part availability updated to false
    $this->assertDatabaseHas('spare_parts', [
        'id' => $sparePart->id,
        'is_available' => false,
        'condition' => 'Normal' // condition should remain unchanged for stock out
    ]);
});

it('validates stock movement required fields based on type in', function () {
    $response = $this->actingAs($this->admin)->post('/stock-movement', [
        'type' => 'in',
        // Missing pic_name, date, condition, location_id, spare_part_ids
    ]);

    $response->assertSessionHasErrors(['pic_name', 'date', 'condition', 'location_id', 'spare_part_ids']);
});

it('validates stock movement required fields based on type out', function () {
    $response = $this->actingAs($this->admin)->post('/stock-movement', [
        'type' => 'out',
        // Missing pic_name, date, destination, spare_part_ids
    ]);

    $response->assertSessionHasErrors(['pic_name', 'date', 'destination', 'spare_part_ids']);
});
