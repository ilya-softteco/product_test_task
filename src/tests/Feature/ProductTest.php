<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_all_product()
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200)->assertJsonFragment(
            [
                'id'=>1,
            ]
        );
    }

    public function test_get_one_product()
    {
        $response = $this->get('/api/products/1');

        $response->assertStatus(200)->assertJsonStructure([
            'data' =>
                [
                    0 => [
                        'id',
                        'name',
                        'price',
                        'VAT'
                    ]
                ]
        ]);
    }

    public function test_get_one_product_full()
    {
        $response = $this->get('/products/1?full=true');

        $response->assertStatus(200)->assertJsonStructure([
            'data' =>
                [
                    0 => [
                        'id',
                        'name',
                        'price',
                        'VAT',
                        'price_with_VAT',
                        'category',
                        'description'
                    ]]
        ]);
    }

    public function test_add_product()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('POST', '/api/products/',
            ['name' => now(),
                'price' => rand(1, 3324),
                'VAT' => rand(0, 50),
                "category" => "testCategory",
                'description' => 'testDescription'
            ]
        );

        $response->assertStatus(201);
    }

    public function test_update_product()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->json('PUT', '/api/products/1',
            [
                'name' => now(),
                'price' => rand(1, 3324),
                'VAT' => rand(0, 50),
                "category" => "testCategory",
                'description' => 'description_description'
            ]
        );

        $response->assertStatus(200);
    }

}
