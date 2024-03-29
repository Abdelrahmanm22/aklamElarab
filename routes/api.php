<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdvertisementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LibraryController;
use App\Http\Controllers\Api\MarkController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});


Route::group(['middleware'=>'jwt.verify'],function(){

    ///Routes For Admin only
    // Route::group(['middleware'=>'adminCheck'],function(){
    //     Route::post('/addBook',[BookController::class,'create']);
    //     Route::get('/allBook', [BookController::class, 'index']);
    // });

    ///Routes For Author only
    Route::group(['middleware'=>'authorCheck'],function(){
        Route::get('/getMyBooks',[AuthorController::class,'getMyBooks']);
    });

    ///Routes For Author and Reader (together)
    Route::group(['middleware'=>'readerAuthorCheck'],function(){
        Route::post('/updateInfo',[UserController::class,'update']);
        Route::post('/updateImage',[UserController::class,'updateImage']);
        Route::get('/allBooks', [BookController::class, 'index']);
        Route::get('/latestBooks',[BookController::class,'getLatest']);
        Route::get('/highestBooks',[BookController::class,'getHighestRate']);
        Route::post('/newComment',[CommentController::class,'create']);
        Route::get('/getBook/{id}',[BookController::class,'getBook']);
        Route::get('/getRate/{book_id}',[RatingController::class,'getRating']);
        Route::post('/makeRate',[RatingController::class,'create']);
        Route::put('/updateRate',[RatingController::class,'update']);
        Route::get('/increaseViews/{id}',[BookController::class,'open']);
        Route::get('/getLibrary',[LibraryController::class,'index']);
        Route::post('/addtoLibrary',[LibraryController::class,'OpenBooKToLibrary']);
        Route::delete('/deleteFromLibrary',[LibraryController::class,'delete']);
        Route::get('/openBook/{bookId}',[MarkController::class,'open']);
        Route::put('/closeBook',[MarkController::class,'close']);
        Route::get('/categories',[CategoryController::class,'index']);
        Route::get('/category/{id}',[CategoryController::class,'getCategory']);
        Route::post('/search',[SearchController::class,'search']);
        Route::get('/authorProfile/{id}',[AuthorController::class,'getAuthor']);
        Route::get('/advertisements',[AdvertisementController::class,'index']);
    });
});
