<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');
        $subcategories = Subcategory::pluck('id', 'name');
        $vendors = User::where('role', 'Vendor')->pluck('id');
       
        $products = [
            ['name' => 'iPhone 15', 'category_id' => $categories['Electronics'] ?? null, 'subcategory_id' => $subcategories['Mobile Phones'] ?? null, 'price' => 1000,'stock'=>'1'],
            ['name' => 'MacBook Pro', 'category_id' => $categories['Electronics'] ?? null, 'subcategory_id' => $subcategories['Laptops'] ?? null, 'price' => 2500,'stock'=>'1'],
            ['name' => 'Men T-Shirt', 'category_id' => $categories['Fashion'] ?? null, 'subcategory_id' => $subcategories['Men Clothing'] ?? null, 'price' => 20,'stock'=>'1'],
            ['name' => 'Women Dress', 'category_id' => $categories['Fashion'] ?? null, 'subcategory_id' => $subcategories['Women Clothing'] ?? null, 'price' => 35,'stock'=>'1'],
            ['name' => 'Mixer Grinder', 'category_id' => $categories['Home & Kitchen'] ?? null, 'subcategory_id' => $subcategories['Kitchen Appliances'] ?? null, 'price' => 100,'stock'=>'1'],
            ['name' => 'Sofa Set', 'category_id' => $categories['Home & Kitchen'] ?? null, 'subcategory_id' => $subcategories['Furniture'] ?? null, 'price' => 500,'stock'=>'1'],
            ['name' => 'Harry Potter Book', 'category_id' => $categories['Books'] ?? null, 'subcategory_id' => $subcategories['Fiction Books'] ?? null, 'price' => 15,'stock'=>'1'],
            ['name' => 'Self-Help Guide', 'category_id' => $categories['Books'] ?? null, 'subcategory_id' => $subcategories['Non-fiction Books'] ?? null, 'price' => 20,'stock'=>'1'],
            ['name' => 'Cricket Bat', 'category_id' => $categories['Sports'] ?? null, 'subcategory_id' => $subcategories['Cricket'] ?? null, 'price' => 50,'stock'=>'1'],
            ['name' => 'Football', 'category_id' => $categories['Sports'] ?? null, 'subcategory_id' => $subcategories['Football'] ?? null, 'price' => 30,'stock'=>'1'],
        ];

      
        $products = array_filter($products, fn($product) => !is_null($product['category_id']) && !is_null($product['subcategory_id']));

        foreach ($products as &$product) {
            $product['vendor_id'] = $vendors->random(); // Assign a random vendor ID
        }

        Product::insert($products);
    }
}
