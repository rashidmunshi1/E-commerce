<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $subcategories = [
            ['name' => 'Mobile Phones', 'category_id' => $categories['Electronics'] ?? null],
            ['name' => 'Laptops', 'category_id' => $categories['Electronics'] ?? null],
            ['name' => 'Men Clothing', 'category_id' => $categories['Fashion'] ?? null],
            ['name' => 'Women Clothing', 'category_id' => $categories['Fashion'] ?? null],
            ['name' => 'Kitchen Appliances', 'category_id' => $categories['Home & Kitchen'] ?? null],
            ['name' => 'Furniture', 'category_id' => $categories['Home & Kitchen'] ?? null],
            ['name' => 'Fiction Books', 'category_id' => $categories['Books'] ?? null],
            ['name' => 'Non-fiction Books', 'category_id' => $categories['Books'] ?? null],
            ['name' => 'Cricket', 'category_id' => $categories['Sports'] ?? null],
            ['name' => 'Football', 'category_id' => $categories['Sports'] ?? null],
        ];

        $subcategories = array_filter($subcategories, fn($sub) => !is_null($sub['category_id']));

        Subcategory::insert($subcategories);
    }
}
