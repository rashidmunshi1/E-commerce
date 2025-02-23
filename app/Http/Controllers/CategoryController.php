<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index(Request $request)
   {
      $categories = Category::all();

      return view('admin.category', compact('categories'));
   }
   public function store(Request $request, Category $category)
   {
      $request->validate([
         'name' => 'required|string|max:255|unique:categories,name',
      ]);
      
      $category->create($request->all());

      return response()->json([
         'status' => true
      ]);
   }

   public function destroy(Request $request, Category $category)
   {
      $category->find($request->categoryId)->delete();

      return response()->json([
         'status' => true,
         'message' => 'Delete category successfully'
      ]);
   }
   public function update(Request $request, Category $category)
   {
      $request->validate([
         'name' => 'required|string|max:255|unique:categories,name',
      ]);

      $category = $category->find($request->categoryId);

      $category->update([
         'name' => $request->name
      ]);

      return response()->json([
         'status' => true
      ]);
   }
}
