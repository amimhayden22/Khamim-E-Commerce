<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|not_in:0|min:1|numeric',
            'stock'         => 'required|numeric|min:1',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description'   => 'nullable|max:150',
            'status'        => 'required|in:active,inactive',
        ]);

        $productData = [
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'price'         => $request->price,
            'stock'         => $request->stock,
            'description'   => $request->description,
            'status'        => $request->status,
        ];

        if ($request->has('image')) {
            $file = $request->file('image');
            $newFile = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->move('assets/img/products/', $newFile);
            $productData['image'] = $newFile;
        }

        Product::create($productData);

        return redirect('/dasbor/products')->with('success', 'Produk berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|not_in:0|min:1|numeric',
            'stock'         => 'required|numeric|min:1',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description'   => 'nullable|max:150',
            'status'        => 'required|in:active,inactive',
        ]);

        $product = Product::findOrFail($id);
        $productData = [
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'price'         => $request->price,
            'stock'         => $request->stock,
            'description'   => $request->description,
            'status'        => $request->status,
        ];

        if ($request->has('image')) {
            if(File::exists('assets/img/products/'.$product->image)) {
                File::delete('assets/img/products/'.$product->image);
            }
            $file = $request->file('image');
            $newFile = Str::uuid().'.'.$file->getClientOriginalExtension();
            $file->move('assets/img/products/', $newFile);
            $productData['image'] = $newFile;
        }

        $product->update($productData);

        return redirect('/dasbor/products')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if(File::exists('assets/img/products/'.$product->image)) {
            File::delete('assets/img/products/'.$product->image);
        }
        $product->delete();

        return redirect('/dasbor/products')->with('success', 'Produk berhasil dihapus.');
    }
}
