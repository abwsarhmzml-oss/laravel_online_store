<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('category')
            ->whereBelongsTo($request->user(), 'owner')
            ->latest()
            ->get();

        return view('owner.products.index', ['products' => $products]);
    }

    public function create(): View
    {
        return view('owner.products.create', [
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedProduct($request);
        $validated['user_id'] = $request->user()->id;
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image']);
        Product::query()->create($validated);

        return redirect()->route('owner.products.index')->with('status', 'تمت إضافة المنتج بنجاح.');
    }

    public function edit(Request $request, Product $product): View
    {
        $this->authorizeOwner($request, $product);

        return view('owner.products.edit', [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeOwner($request, $product);
        $validated = $this->validatedProduct($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('products', 'public');

            if ($product->image_path !== null) {
                Storage::disk('public')->delete($product->image_path);
            }

            $validated['image_path'] = $newImagePath;
        }

        unset($validated['image']);
        $product->update($validated);

        return redirect()->route('owner.products.index')->with('status', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $this->authorizeOwner($request, $product);

        if ($product->image_path !== null) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('owner.products.index')->with('status', 'تم حذف المنتج.');
    }

    /** @return array<string, mixed> */
    private function validatedProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }

    private function authorizeOwner(Request $request, Product $product): void
    {
        abort_unless($product->user_id === $request->user()->id, 403);
    }
}
