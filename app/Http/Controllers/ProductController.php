<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan data produk
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        return view('pages.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products,name',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drinks,snacks',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        // Simpan produk baru
        Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
            'image' => $filename,
        ]);

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|min:3|unique:products,name,' . $id,
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drinks,snacks',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

        $product = Product::findOrFail($id);
        $filename = $product->image;

        // Cek apakah ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage
            if ($filename) {
                Storage::delete('public/products/' . $filename);
            }

            // Simpan gambar baru
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        }

        // Update produk
        $product->update([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
            'image' => $filename,
        ]);

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage sebelum menghapus produk
        if ($product->image) {
            Storage::delete('public/products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
