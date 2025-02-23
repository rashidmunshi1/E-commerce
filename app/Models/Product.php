<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['name', 'category_id', 'subcategory_id', 'vendor_id', 'description', 'price', 'stock'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function vendorUser()
    {
        return $this->belongsTo(User::class, 'vendor_id')->where('role', 'vendor');
    }
    
}
