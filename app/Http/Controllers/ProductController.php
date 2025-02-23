<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display the product page.
     */
    public function index()
    {
        $categories = Category::all();

        $products = Product::with(['category', 'subcategory'])->get();

        return view('admin.product', compact('categories', 'products'));
    }

    /**
     * Fetch subcategories based on selected category.
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        return response()->json($subcategories);
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'vendor_id' => Auth::id(),
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return response()->json(['success' => 'Product added successfully']);
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->productId);
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return response()->json(['success' => 'Product updated successfully']);
    }

    /**
     * Delete a product.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->productId);
        $product->delete();

        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function getProducts(){
        $products = Product::with('category','subcategory','vendorUser')->get();
        return view('admin.vendor-product',compact('products'));
    }
}
