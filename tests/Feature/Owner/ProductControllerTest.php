<?php

namespace Tests\Feature\Owner;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_is_redirected_to_login_from_product_management(): void
    {
        $response = $this->get(route('owner.products.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_owner_creates_product_with_an_uploaded_image(): void
    {
        Storage::fake('public');
        $owner = User::factory()->create();
        $category = Category::query()->where('slug', 'men')->firstOrFail();
        $image = UploadedFile::fake()->image('jacket.jpg');
        $productData = $this->validProductData($category);
        $productData['image'] = $image;

        $response = $this->actingAs($owner)->post(route('owner.products.store'), $productData);

        $response->assertRedirect(route('owner.products.index'));
        $product = Product::query()->firstOrFail();
        $this->assertModelExists($product);
        $this->assertSame($owner->id, $product->user_id);
        $this->assertSame('Linen jacket', $product->name);
        $this->assertTrue(Storage::disk('public')->exists($product->image_path));
    }

    public function test_owner_updates_product_details_and_replaces_its_image(): void
    {
        Storage::fake('public');
        $owner = User::factory()->create();
        $category = Category::query()->where('slug', 'men')->firstOrFail();
        $oldImagePath = 'products/old-jacket.jpg';
        Storage::disk('public')->put($oldImagePath, 'old image');
        $product = Product::factory()->for($owner, 'owner')->for($category)->create([
            'image_path' => $oldImagePath,
        ]);
        $productData = $this->validProductData($category);
        $productData['name'] = 'Updated jacket';
        $productData['price'] = '79.50';
        $productData['description'] = 'Updated product description';
        $productData['image'] = UploadedFile::fake()->image('updated-jacket.jpg');

        $response = $this->actingAs($owner)->put(route('owner.products.update', $product), $productData);

        $response->assertRedirect(route('owner.products.index'));
        $product->refresh();
        $this->assertSame('Updated jacket', $product->name);
        $this->assertSame('79.50', $product->price);
        $this->assertNotSame($oldImagePath, $product->image_path);
        $this->assertFalse(Storage::disk('public')->exists($oldImagePath));
        $this->assertTrue(Storage::disk('public')->exists($product->image_path));
    }

    public function test_owner_deletes_product_and_its_image(): void
    {
        Storage::fake('public');
        $owner = User::factory()->create();
        $imagePath = 'products/to-delete.jpg';
        Storage::disk('public')->put($imagePath, 'product image');
        $product = Product::factory()->for($owner, 'owner')->create(['image_path' => $imagePath]);

        $response = $this->actingAs($owner)->delete(route('owner.products.destroy', $product));

        $response->assertRedirect(route('owner.products.index'));
        $this->assertModelMissing($product);
        $this->assertFalse(Storage::disk('public')->exists($imagePath));
    }

    public function test_another_user_cannot_update_a_product(): void
    {
        $owner = User::factory()->create();
        $anotherUser = User::factory()->create();
        $product = Product::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($anotherUser)->put(route('owner.products.update', $product), [
            ...$this->validProductData($product->category),
            'name' => 'Changed by another user',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
            'user_id' => $owner->id,
        ]);
    }

    public function test_another_user_cannot_delete_a_product(): void
    {
        $owner = User::factory()->create();
        $anotherUser = User::factory()->create();
        $product = Product::factory()->for($owner, 'owner')->create();

        $response = $this->actingAs($anotherUser)->delete(route('owner.products.destroy', $product));

        $response->assertForbidden();
        $this->assertModelExists($product);
    }

    public function test_product_form_rejects_missing_required_fields(): void
    {
        $owner = User::factory()->create();

        $response = $this->actingAs($owner)->post(route('owner.products.store'), []);

        $response->assertSessionHasErrors([
            'category_id',
            'name' => 'The name field is required.',
            'price',
            'description',
        ]);
        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_form_rejects_a_negative_price(): void
    {
        $owner = User::factory()->create();
        $category = Category::query()->where('slug', 'men')->firstOrFail();
        $productData = $this->validProductData($category);
        $productData['price'] = '-1';

        $response = $this->actingAs($owner)->post(route('owner.products.store'), $productData);

        $response->assertSessionHasErrors([
            'price' => 'The price field must be at least 0.',
        ]);
        $this->assertDatabaseCount('products', 0);
    }

    /** @return array{category_id: int, name: string, price: string, description: string, is_active: bool} */
    private function validProductData(Category $category): array
    {
        return [
            'category_id' => $category->id,
            'name' => 'Linen jacket',
            'price' => '59.99',
            'description' => 'A lightweight jacket for everyday wear.',
            'is_active' => true,
        ];
    }
}
