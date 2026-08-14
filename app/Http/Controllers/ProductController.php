<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images')->orderBy('sort_order')->orderBy('id')->get();

        return view('master.products.index', compact('products'));
    }

    public function create()
    {
        return view('master.products.edit', ['product' => new Product()]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request, null);

        $product = Product::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?: Str::slug($validated['title']),
            'short_description' => $validated['short_description'] ?? '',
            'content' => $validated['content'] ?? '',
            'icon' => $validated['icon'] ?? '',
            'featured_image' => $this->uploadFile($request, 'featured_image', 'products'),
            'disk' => 'public',
            'meta_description' => $validated['meta_description'] ?? '',
            'meta_keywords' => $validated['meta_keywords'] ?? '',
            'sort_order' => $validated['sort_order'] ?? (Product::max('sort_order') + 1),
            'is_active' => $request->has('is_active'),
        ]);

        $this->handleGallery($request, $product);

        return redirect()->route('master.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('master.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $this->validateRequest($request, $product);

        if ($request->hasFile('featured_image')) {
            $this->deleteFile($product->featured_image, $product->disk);
            $product->featured_image = $request->file('featured_image')->store('products', 'public');
            $product->disk = 'public';
        }
        if ($request->boolean('clear_featured') && $product->featured_image) {
            $this->deleteFile($product->featured_image, $product->disk);
            $product->featured_image = null;
        }

        $product->title = $validated['title'];
        $product->slug = $validated['slug'] ?: Str::slug($validated['title']);
        $product->short_description = $validated['short_description'] ?? '';
        $product->content = $validated['content'] ?? '';
        $product->icon = $validated['icon'] ?? '';
        $product->meta_description = $validated['meta_description'] ?? '';
        $product->meta_keywords = $validated['meta_keywords'] ?? '';
        $product->sort_order = $validated['sort_order'] ?? $product->sort_order;
        $product->is_active = $request->has('is_active');
        $product->save();

        $this->handleGallery($request, $product);

        return redirect()->route('master.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->featured_image) {
            $this->deleteFile($product->featured_image, $product->disk);
        }
        foreach ($product->images as $img) {
            $this->deleteFile($img->image, $img->disk);
        }
        $product->images()->delete();
        $product->delete();

        return redirect()->route('master.products.index')->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        $this->deleteFile($image->image, $image->disk);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function show(Product $product)
    {
        $product->load('images');

        if (! $product->is_active) {
            abort(404);
        }

        PageView::record('product', $product->id);

        $related = Product::active()->where('id', '!=', $product->id)->limit(3)->get();

        return view('products.show', compact('product', 'related'));
    }

    private function validateRequest(Request $request, ?Product $product): array
    {
        $slugRule = ['nullable', 'string', 'max:200'];
        if ($request->filled('slug')) {
            $slugRule[] = 'unique:products,slug,' . ($product?->id ?? 'NULL');
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => $slugRule,
            'short_description' => ['nullable', 'string', 'max:300'],
            'content' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'meta_keywords' => ['nullable', 'string', 'max:300'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'gallery.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'featured_image.image' => 'Featured image must be an image.',
            'featured_image.mimes' => 'Allowed: jpg, jpeg, png, webp.',
            'featured_image.max' => 'Max size 2MB.',
            'gallery.*.image' => 'Gallery file must be an image.',
            'gallery.*.mimes' => 'Allowed: jpg, jpeg, png, webp.',
            'gallery.*.max' => 'Max size 2MB per image.',
        ]);
    }

    private function uploadFile(Request $request, string $field, string $folder): ?string
    {
        if ($request->hasFile($field)) {
            return $request->file($field)->store($folder, 'public');
        }

        return null;
    }

    private function handleGallery(Request $request, Product $product): void
    {
        if ($request->hasFile('gallery')) {
            $order = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create([
                    'image' => $path,
                    'disk' => 'public',
                    'sort_order' => ++$order,
                ]);
            }
        }
    }

    private function deleteFile(?string $path, string $disk): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }
    }
}