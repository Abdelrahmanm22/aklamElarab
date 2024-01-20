<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search($word){
        // Search for books with names containing the given word
        $books = $this->aboutBooks($word);
        

        // Search for authors with names containing the given word
        $authors = $this->aboutAuthors($word);

        
        $results = [
            'books' => $books,
            'authors' => $authors,
        ];
        return $this->apiResponse($results,"Get Result of Search Successfully.",200);
    }

    public function aboutBooks($word){
        return Book::where('name', 'like', '%' . $word . '%')
        ->orderByRaw("ABS(CHAR_LENGTH(name) - CHAR_LENGTH(?))", [$word]) ///order by similarity
        ->get();
    }

    public function aboutAuthors($word){
        return User::where('type', 'author')
                    ->where('name', 'like', '%' . $word . '%')
                    ->orderByRaw("ABS(CHAR_LENGTH(name) - CHAR_LENGTH(?))", [$word]) ///order by similarity
                    ->get();
    }

    
}
