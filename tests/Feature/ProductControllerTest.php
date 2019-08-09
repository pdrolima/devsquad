<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_products()
    {
        factory(Product::class)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('get', '/api/products');
        
        $response->assertStatus(200);
        $this->assertCount(1, $response->original);
    }

    public function test_user_can_create_a_product()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('post', '/api/products', 
            [
                'name' => 'Apple iPhone',
                'description' => 'Samsung is better.',
                'category' => 1,
                'price' => 999,
            ]
        );

        $response->assertStatus(200);
    }

    public function test_user_can_create_a_product_with_image()
    {
        $user = factory(User::class)->create();

        Storage::fake('products');
        $file = UploadedFile::fake()->image('iphone.jpg');
        
        $response = $this->actingAs($user, 'api')
            ->json('post', '/api/products', 
            [
                'name' => 'Apple iPhone',
                'image' => $file,
                'description' => 'Samsung is better.',
                'category' => 1,
                'price' => 999,
            ]
        );

        $response->assertStatus(200);
        
    }

    public function test_user_can_see_a_single_product()
    {
        $product = factory(Product::class)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('get', '/api/products/' . $product->id);
        
        $response->assertStatus(200)
        ->assertJson([
            'name' => 'Apple',
            'description' => 'Samsung is better',
            'category' => 1,
            'price' => 999
        ]);
    }

    public function test_user_can_update_a_product()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $product->name = 'Samsung Galaxy Note 10';

        $response = $this->actingAs($user, 'api')
            ->json('patch', '/api/products/' . $product->id, $product->toArray());
        
        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Samsung Galaxy Note 10'
            ]);
    }

    public function test_user_can_soft_delete_a_product()
    {
        $product = factory(Product::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', '/api/products/' . $product->id);

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('products', $product->toArray());
    }
}
