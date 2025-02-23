<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware(['auth', 'verified']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update-picture');
    Route::get('/sub-categories',[CategoryController::class, 'index'])->name('SubCategories.index');
    
    Route::controller(CategoryController::class)->prefix('category')->group(function () {
        Route::get('/categories', 'index')->name('admin.Categories.index');
        Route::post('store','store')->name('admin.categories.store');
        Route::delete('delete', 'destroy')->name('admin.categories.delete');
        Route::post('update','update')->name('admin.categories.update');
    });

    Route::controller(SubCategoryController::class)->prefix('subcategory')->group(function () {
        Route::get('/subcategories', 'index')->name('admin.subcategories.index');
        Route::post('store','store')->name('admin.subcategories.store');
        Route::delete('delete', 'destroy')->name('admin.subcategories.delete');
        Route::post('update','update')->name('admin.subcategories.update');

    }); 

    Route::controller(SubCategoryController::class)->prefix('subcategory')->group(function () {
        Route::get('/subcategories', 'index')->name('admin.subcategories.index');
        Route::post('store','store')->name('admin.subcategories.store');
        Route::delete('delete', 'destroy')->name('admin.subcategories.delete');
        Route::post('update','update')->name('admin.subcategories.update');
    }); 

    Route::controller(ProductController::class)->prefix('product')->group(function () {
        Route::get('/','index')->name('products.index');
        Route::post('store','store')->name('product.store');
        Route::delete('delete', 'destroy')->name('product.delete');
        Route::post('update','update')->name('product.update');
        Route::get('subcategories','getSubcategories')->name('admin.getSubcategories');
        Route::get('products','getProducts')->name('admin.getProducts');
    }); 
   

});

require __DIR__.'/auth.php';
 