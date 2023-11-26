<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AuthorController extends Controller
{
    //

    public function getMyBooks(){
        $books = Book::where('author_id', '=', auth()->user()->id)
        ->select('id', 'name', 'description','image','file','rate','created_at')
        ->get();
        return $this->apiResponse($books,'ok',200);
    }
}
