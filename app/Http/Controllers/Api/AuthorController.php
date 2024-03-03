<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AuthorController extends Controller
{
    //

    public function getMyBooks(){
        $books = Book::where('author_id', '=', auth('api')->user()->id)
        ->select('id', 'name', 'description','image','file','rate','created_at')
        ->get();
        return $this->apiResponse($books,'ok',200);
    }

    ///this function to get profile author by id
    public function getAuthor($id){
        $author = User::with('related', 'books')
            ->where('type', '=', 'author')
            ->find($id);
        if(!$author){
            return $this->apiResponse(null,"Not Found Author by this ID",404);
        }

        return $this->apiResponse($author,"Get Profile Author Successfully",200);
    }
}
