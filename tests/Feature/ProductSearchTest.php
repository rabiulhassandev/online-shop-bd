<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can search for products by name', function () {
    $product1 = Product::factory()->create(['name' => 'Denim Shirt', 'is_active' => true]);
    $product2 = Product::factory()->create(['name' => 'Cotton Pant', 'is_active' => true]);

    $response = $this->get(route('products.index', ['search' => 'Denim']));

    $response->assertStatus(200);
    $response->assertSee('Denim Shirt');
    $response->assertDontSee('Cotton Pant');
});

test('a user can search for products by description', function () {
    $product1 = Product::factory()->create([
        'name' => 'Shirt A', 
        'description' => 'Comfortable and stylish', 
        'is_active' => true
    ]);
    $product2 = Product::factory()->create([
        'name' => 'Shirt B', 
        'description' => 'Rough and tough', 
        'is_active' => true
    ]);

    $response = $this->get(route('products.index', ['search' => 'Comfortable']));

    $response->assertStatus(200);
    $response->assertSee('Shirt A');
    $response->assertDontSee('Shirt B');
});
