<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $subcategories = Subcategory::with('category')->get();

        return view('admin.subcategory', compact('subcategories', 'categories'));
    }
    public function store(Request $request, Subcategory $Subcategory)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $Subcategory->create($request->all());

        return response()->json([
            'status' => true
        ]);
    }

    public function destroy(Request $request, Subcategory $Subcategory)
    {
        $Subcategory->find($request->SubcategoryId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Delete Subcategory successfully'
        ]);
    }
    public function update(Request $request, Subcategory $Subcategory)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $Subcategory=  $Subcategory->find($request->subcategoryId);

        $Subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name
        ]);
        return response()->json([
            'status' => true
        ]);
    }
}
