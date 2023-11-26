<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\RatingController;
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
    Route::group(['middleware'=>'adminCheck'],function(){
        Route::post('/addAuthor',[AdminController::class,'addAuthor']);
        Route::get('/getUsers',[AdminController::class,'getAllUsers']);
        Route::get('/getAuthors',[AdminController::class,'getAuthors']);
        Route::post('/addBook',[BookController::class,'create']);
    });

    Route::group(['middleware'=>'authorCheck'],function(){
        Route::get('/getMyBooks',[AuthorController::class,'getMyBooks']);
    });

    Route::group(['middleware'=>'readerCheck'],function(){
        Route::get('/allBooks',[BookController::class,'index']);
        Route::get('/latestBooks',[BookController::class,'getLatest']);
        Route::get('/highestBooks',[BookController::class,'getHighestRate']);
        Route::post('/newComment',[CommentController::class,'create']);
        Route::get('/getBook/{id}',[BookController::class,'getBook']);
        Route::get('/getRate/{reader_id}/{book_id}',[RatingController::class,'getRating']);
        Route::post('/makeRate',[RatingController::class,'create']);
        Route::post('/updateRate',[RatingController::class,'update']);
    });
});