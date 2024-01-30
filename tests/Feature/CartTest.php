<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_a_product_to_the_cart()
    {
        // Crear un producto
        $product = Product::factory()->create();

        // Crear un carrito
        $cart = Cart::factory()->create();

        // Añadir el producto al carrito
        $cart->Products()->attach($product);

        // Verificar que el producto se ha añadido correctamente
        $this->assertCount(1, $cart->Products);
    }
}
