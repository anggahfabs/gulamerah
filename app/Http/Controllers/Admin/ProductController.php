<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductPriceTier;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'variants', 'priceTiers'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('raw_material', 'like', "%{$search}%")
                  ->orWhere('product_form', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'raw_material' => 'required|string|max:100',
            'product_form' => 'required|string|max:100',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'moisture_content' => 'nullable|string|max:100',
            'mesh_size' => 'nullable|string|max:100',
            'brix_content' => 'nullable|string|max:100',
            'shelf_life' => 'nullable|string|max:100',
            'storage_instruction' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:3072',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.packaging_name' => 'required_with:variants|string|max:255',
            'variants.*.packaging_type' => 'required_with:variants|in:Retail,Bulk',
            'variants.*.unit_weight_kg' => 'required_with:variants|numeric|min:0',
            'variants.*.retail_price' => 'nullable|numeric|min:0',
            // Price tiers
            'price_tiers' => 'nullable|array',
            'price_tiers.*.min_quantity_kg' => 'required_with:price_tiers|numeric|min:0',
            'price_tiers.*.max_quantity_kg' => 'nullable|numeric|min:0',
            'price_tiers.*.price_per_kg' => 'required_with:price_tiers|numeric|min:0',
            'price_tiers.*.note' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create($validated);

        // Store Variants
        if ($request->filled('variants')) {
            foreach ($request->variants as $variant) {
                if (!empty($variant['packaging_name'])) {
                    $product->variants()->create([
                        'packaging_name' => $variant['packaging_name'],
                        'packaging_type' => $variant['packaging_type'] ?? 'Retail',
                        'unit_weight_kg' => $variant['unit_weight_kg'] ?? 1.0,
                        'retail_price' => $variant['retail_price'] ?? null,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Store Price Tiers
        if ($request->filled('price_tiers')) {
            foreach ($request->price_tiers as $tier) {
                if (isset($tier['min_quantity_kg']) && isset($tier['price_per_kg'])) {
                    $product->priceTiers()->create([
                        'min_quantity_kg' => $tier['min_quantity_kg'],
                        'max_quantity_kg' => !empty($tier['max_quantity_kg']) ? $tier['max_quantity_kg'] : null,
                        'price_per_kg' => $tier['price_per_kg'],
                        'note' => $tier['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk gula ' . $product->name . ' berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $product->load(['variants', 'priceTiers', 'images']);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'raw_material' => 'required|string|max:100',
            'product_form' => 'required|string|max:100',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'moisture_content' => 'nullable|string|max:100',
            'mesh_size' => 'nullable|string|max:100',
            'brix_content' => 'nullable|string|max:100',
            'shelf_life' => 'nullable|string|max:100',
            'storage_instruction' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:3072',
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.packaging_name' => 'required_with:variants|string|max:255',
            'variants.*.packaging_type' => 'required_with:variants|in:Retail,Bulk',
            'variants.*.unit_weight_kg' => 'required_with:variants|numeric|min:0',
            'variants.*.retail_price' => 'nullable|numeric|min:0',
            // Price tiers
            'price_tiers' => 'nullable|array',
            'price_tiers.*.min_quantity_kg' => 'required_with:price_tiers|numeric|min:0',
            'price_tiers.*.max_quantity_kg' => 'nullable|numeric|min:0',
            'price_tiers.*.price_per_kg' => 'required_with:price_tiers|numeric|min:0',
            'price_tiers.*.note' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update($validated);

        // Sync Variants: Delete and recreate cleanly
        if ($request->has('variants')) {
            $product->variants()->delete();
            foreach ($request->variants as $variant) {
                if (!empty($variant['packaging_name'])) {
                    $product->variants()->create([
                        'packaging_name' => $variant['packaging_name'],
                        'packaging_type' => $variant['packaging_type'] ?? 'Retail',
                        'unit_weight_kg' => $variant['unit_weight_kg'] ?? 1.0,
                        'retail_price' => $variant['retail_price'] ?? null,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Sync Price Tiers: Delete and recreate cleanly
        if ($request->has('price_tiers')) {
            $product->priceTiers()->delete();
            foreach ($request->price_tiers as $tier) {
                if (isset($tier['min_quantity_kg']) && isset($tier['price_per_kg'])) {
                    $product->priceTiers()->create([
                        'min_quantity_kg' => $tier['min_quantity_kg'],
                        'max_quantity_kg' => !empty($tier['max_quantity_kg']) ? $tier['max_quantity_kg'] : null,
                        'price_per_kg' => $tier['price_per_kg'],
                        'note' => $tier['note'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Data produk ' . $product->name . ' berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk ' . $name . ' berhasil dihapus.');
    }

    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        $statusText = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Status produk {$product->name} berhasil {$statusText}.");
    }
}
