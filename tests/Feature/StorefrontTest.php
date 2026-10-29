<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_homepage_displays_the_storefront(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Style for every')
            ->assertSee('Shop by category')
            ->assertSee('Our collection');
    }

    public function test_each_audience_has_a_category_page(): void
    {
        foreach (['men' => 'Men', 'women' => 'Women', 'kids' => 'Kids'] as $path => $label) {
            $this->get('/'.$path)
                ->assertOk()
                ->assertSee($label)
                ->assertSee('This edit is taking shape.');
        }
    }

    public function test_search_query_is_carried_into_the_empty_catalog_message(): void
    {
        $this->get('/store?q=linen')
            ->assertOk()
            ->assertSee('linen')
            ->assertSee('Search results');
    }

    public function test_homepage_displays_product_image_price_and_description(): void
    {
        Product::factory()->create([
            'name' => 'Washed cotton shirt',
            'price' => '48.00',
            'description' => 'Soft cotton for everyday wear.',
            'image_path' => 'products/washed-cotton-shirt.jpg',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Washed cotton shirt')
            ->assertSee('48.00')
            ->assertSee('Soft cotton for everyday wear.')
            ->assertSee('storage/products/washed-cotton-shirt.jpg');
    }

    public function test_homepage_hides_inactive_products(): void
    {
        Product::factory()->create(['name' => 'Published product', 'is_active' => true]);
        Product::factory()->create(['name' => 'Hidden product', 'is_active' => false]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee('Published product')
            ->assertDontSee('Hidden product');
    }

    public function test_category_page_only_displays_products_from_that_category(): void
    {
        $men = Category::query()->where('slug', 'men')->firstOrFail();
        $women = Category::query()->where('slug', 'women')->firstOrFail();
        Product::factory()->for($men)->create(['name' => 'Men category shirt']);
        Product::factory()->for($women)->create(['name' => 'Women category dress']);

        $response = $this->get(route('products.men'));

        $response->assertOk()
            ->assertSee('Men category shirt')
            ->assertDontSee('Women category dress');
    }

    public function test_existing_login_and_registration_pages_remain_available(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/newlogin')->assertOk();
    }
}
