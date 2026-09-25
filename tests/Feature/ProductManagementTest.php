<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_with_external_image_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.products.store'), $this->productData([
            'image_url' => 'https://example.com/manto.jpg',
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'name' => 'Camisa de teste',
            'image_url' => 'https://example.com/manto.jpg',
            'image_path' => null,
        ]);
    }

    public function test_admin_can_create_product_with_uploaded_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.products.store'), $this->productData([
            'image_file' => UploadedFile::fake()->image('manto.webp'),
        ]));

        $response->assertRedirect(route('admin.products.index'));
        $product = Product::query()->firstOrFail();

        $this->assertNotNull($product->image_path);
        Storage::disk('public')->assertExists($product->image_path);
        $this->assertStringContainsString('/storage/products/', $product->image_source);
    }

    public function test_uploaded_image_has_priority_over_external_url(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.products.store'), $this->productData([
            'image_url' => 'https://example.com/fallback.jpg',
            'image_file' => UploadedFile::fake()->image('manto.jpg'),
        ]));

        $product = Product::query()->firstOrFail();

        $this->assertSame('https://example.com/fallback.jpg', $product->image_url);
        $this->assertNotSame($product->image_url, $product->image_source);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_replacing_uploaded_image_removes_the_old_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.products.store'), $this->productData([
            'image_file' => UploadedFile::fake()->image('old.jpg'),
        ]));

        $product = Product::query()->firstOrFail();
        $oldPath = $product->image_path;

        $this->actingAs($user)->put(route('admin.products.update', $product), $this->productData([
            'image_file' => UploadedFile::fake()->image('new.jpg'),
        ]));

        $product->refresh();
        $this->assertNotSame($oldPath, $product->image_path);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_deleting_product_removes_its_uploaded_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.products.store'), $this->productData([
            'image_file' => UploadedFile::fake()->image('manto.jpg'),
        ]));

        $product = Product::query()->firstOrFail();
        $imagePath = $product->image_path;

        $this->actingAs($user)->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        Storage::disk('public')->assertMissing($imagePath);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    private function productData(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Camisa de teste',
            'team' => 'Time de teste',
            'season' => '2026',
            'description' => 'Descrição da camiseta de teste.',
            'price' => '199.90',
            'compare_price' => '229.90',
            'sizes_text' => 'P M G GG',
            'stock' => '10',
            'featured' => '1',
            'active' => '1',
        ], $overrides);
    }
}
