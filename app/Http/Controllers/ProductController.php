<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            try {
                if (env('SUPABASE_ACCESS_KEY_ID')) {
                    $path = $request->file('image')->store('imageproducts', 'supabase');
                    if ($path === false) {
                        throw new \Exception("Failed to upload image to Supabase. Check your credentials and ensure your project is active.");
                    }
                    $data['image'] = \Illuminate\Support\Facades\Storage::disk('supabase')->url($path);
                } else {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads'), $imageName);
                    $data['image'] = 'uploads/' . $imageName;
                }
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->with('error', 'Image upload failed: ' . $e->getMessage() . '. On Vercel, you must set Supabase Storage env variables.');
            }
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            try {
                if ($product->image) {
                    if (str_starts_with($product->image, 'http')) {
                        $filename = basename(parse_url($product->image, PHP_URL_PATH));
                        \Illuminate\Support\Facades\Storage::disk('supabase')->delete('imageproducts/' . $filename);
                    } elseif (file_exists(public_path($product->image))) {
                        @unlink(public_path($product->image));
                    }
                }
                
                if (env('SUPABASE_ACCESS_KEY_ID')) {
                    $path = $request->file('image')->store('imageproducts', 'supabase');
                    if ($path === false) {
                        throw new \Exception("Failed to upload image to Supabase. Check your credentials and ensure your project is active.");
                    }
                    $data['image'] = \Illuminate\Support\Facades\Storage::disk('supabase')->url($path);
                } else {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads'), $imageName);
                    $data['image'] = 'uploads/' . $imageName;
                }
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->with('error', 'Image update failed: ' . $e->getMessage());
            }
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            if (str_starts_with($product->image, 'http') && env('SUPABASE_ACCESS_KEY_ID')) {
                $filename = basename(parse_url($product->image, PHP_URL_PATH));
                \Illuminate\Support\Facades\Storage::disk('supabase')->delete('imageproducts/' . $filename);
            } elseif (file_exists(public_path($product->image))) {
                @unlink(public_path($product->image));
            }
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
