<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test *//** @test */
    public function it_can_create_a_product()
    {
        // Arrange: Buat kategori dan unit menggunakan factory
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();
    
        // Data produk dengan ID kategori dan unit dari factory
        $data = [
            'nama' => 'Sample Product',
            'jenis' => 'Sample Type',
            'merek' => 'Sample Brand',
            'ukuran' => 'Sample Size',
            'harga' => 1000,
            'stok' => 10,
            'category_id' => $category->id,
            'unit_id' => $unit->id,
        ];
    
        // Act: Buat produk baru
        $product = Product::create($data);
    
        // Assert
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Sample Product', $product->nama);
    }
}
