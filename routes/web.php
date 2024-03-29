<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AdvertisementController;
use App\Http\Controllers\Web\AuthorController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\PublisherController;
use App\Http\Controllers\Web\ReaderController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix'=>'dashboard','middleware'=>'auth'],function(){
    Route::get('/home',[AdminController::class,'index'])->name('home');

    Route::group(['prefix'=>'publisher'],function(){
        Route::get('/',[PublisherController::class,'index'])->name('publisher');
        Route::get('/store',[PublisherController::class,'store'])->name('publisher.store');
        Route::post('/create',[PublisherController::class,'create'])->name('publisher.create');
        Route::post('/delete',[PublisherController::class,'delete'])->name('publisher.delete');
    });

    Route::group(['prefix'=>'category'],function(){
        Route::get('/',[CategoryController::class,'index'])->name('category');
        Route::get('/store',[CategoryController::class,'store'])->name('category.store');
        Route::post('/create',[CategoryController::class,'create'])->name('category.create');
        Route::post('/delete',[CategoryController::class,'delete'])->name('category.delete');
    });

    Route::group(['prefix'=>'book'],function(){
        Route::get('/',[BookController::class,'index'])->name('book');
        Route::get('/store',[BookController::class,'store'])->name('book.store');
        Route::post('/create',[BookController::class,'create'])->name('book.create');
        Route::post('/delete',[BookController::class,'delete'])->name('book.delete');
    });

    Route::group(['prefix'=>'advertisement'],function(){
        Route::get('/',[AdvertisementController::class,'index'])->name('advertisement');
        Route::get('/store',[AdvertisementController::class,'store'])->name('advertisement.store');
        Route::post('/create',[AdvertisementController::class,'create'])->name('advertisement.create');
        Route::post('/delete',[AdvertisementController::class,'delete'])->name('advertisement.delete');
    });

    Route::group(['prefix'=>'author'],function(){
        Route::get('/',[AuthorController::class,'index'])->name('author');
        Route::get('/store',[AuthorController::class,'store'])->name('author.store');
        Route::post('/create',[AuthorController::class,'create'])->name('author.create');
        Route::get('/edit/{id}',[AuthorController::class,'edit'])->name('author.edit');
        // Route::post('/update',[AuthorController::class,'update'])->name('author.update');
    });

    Route::group(['prefix'=>'reader'],function(){
        Route::get('/',[ReaderController::class,'index'])->name('reader');
    });
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
