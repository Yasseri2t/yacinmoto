<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Section;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $motoTypes  = \App\Models\MotoType::orderBy('name')->get();
        $sections   = Section::orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories', 'motoTypes', 'sections'));
    }

    public function store()
    {
        request()->validate([
            'name'        => 'required',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
        ]);

        $product = Product::create([
            'name'              => request('name'),
            'slug'              => Str::slug(request('name')) . '-' . uniqid(),
            'category_id'       => request('category_id'),
            'price'             => request('price'),
            'description'       => request('description'),
            'brand'             => request('brand'),
            'compatible_models' => request('compatible_models'),
            'section'           => request('section'),
            'in_stock'          => request()->has('in_stock'),
            'is_piece_of_day'   => request()->has('is_piece_of_day'),
            'image'             => request('image'),
        ]);

        // Save extra images to product_images table
        $this->saveExtraImages($product, request('extra_images'));

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $motoTypes  = \App\Models\MotoType::orderBy('name')->get();
        $sections   = Section::orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories', 'motoTypes', 'sections'));
    }

    public function update(Product $product)
    {
        request()->validate([
            'name'        => 'required',
            'category_id' => 'required',
            'price'       => 'required|numeric',
        ]);

        $product->update([
            'name'              => request('name'),
            'slug'              => Str::slug(request('name')) . '-' . $product->id,
            'category_id'       => request('category_id'),
            'price'             => request('price'),
            'description'       => request('description'),
            'brand'             => request('brand'),
            'compatible_models' => request('compatible_models'),
            'section'           => request('section'),
            'in_stock'          => request()->has('in_stock'),
            'is_piece_of_day'   => request()->has('is_piece_of_day'),
            'image'             => request('image') ?: $product->image,
        ]);

        // Replace extra images: delete old ones then save new ones
        $product->images()->delete();
        $this->saveExtraImages($product, request('extra_images'));

        return redirect()->route('admin.products.index')->with('success', 'Mis à jour!');
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Supprimé!');
    }

    public function show(Product $product) {}

    // Helper: parse textarea (one URL per line) and insert into product_images
    private function saveExtraImages(Product $product, ?string $raw): void
    {
        if (!$raw) return;

        $urls = array_filter(
            array_map('trim', explode("\n", $raw))
        );

        foreach (array_values($urls) as $order => $url) {
            ProductImage::create([
                'product_id' => $product->id,
                'url'        => $url,
                'order'      => $order,
            ]);
        }
    }
}
