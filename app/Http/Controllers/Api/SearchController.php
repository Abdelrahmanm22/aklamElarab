<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search(Request $request)
    {

        // Search for books with names containing the given word
        $books = $this->aboutBooks($request->word);


        // Search for authors with names containing the given word
        $authors = $this->aboutAuthors($request->word);


        $results = [
            'books' => $books,
            'authors' => $authors,
        ];
        return $this->apiResponse($results, "Get Result of Search Successfully.", 200);
    }


    // Search for books with names containing the given word
    public function aboutBooks($word)
    {
        return Book::where('name', 'like', '%' . $word . '%')
            ->orderByRaw("ABS(CHAR_LENGTH(name) - CHAR_LENGTH(?))", [$word]) ///order by similarity
            ->get();
    }

    // Search for authors with names containing the given word
    public function aboutAuthors($word)
    {
        $authors = User::where('type', 'author')
        ->where('name', 'like', '%' . $word . '%')
        ->orderByRaw("ABS(CHAR_LENGTH(name) - CHAR_LENGTH(?))", [$word]) ///order by similarity
        ->get();


        // Fetch the number of books and average rating for each author
        foreach ($authors as $author) {
            $author->num_books = $author->books()->count();
            $author->avg_rating = $author->books()->avg('rate');
        }

        return $authors;
    }
}
