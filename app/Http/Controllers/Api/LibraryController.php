<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    //

    public function index(){
        $library = Library::where('reader_id',auth('api')->user()->id)->first();
        $books = $library->books()->with('author')->get();
        return $this->apiResponse($books,"ok",200);
    }

    ///function to add book to library
    public function OpenBooKToLibrary(Request $request){

        $library = Library::where('reader_id',auth('api')->user()->id)->first();


        if($library->books->contains($request->book_id)){
            return $this->apiResponse(null,"Book is already in the library",200);
        }


        $library->books()->attach($request->book_id);

        return $this->apiResponse(null,"Book Added To Library Successfully",200);
    }

    ///function to delete Book From Library
    public function delete(Request $request)
    {
        $user = auth('api')->user();

        // Find the library of the logged-in user
        $library = Library::where('reader_id', $user->id)->first();

        // Check if the library exists
        if (!$library) {
            return $this->apiResponse(null, "Library not found", 404);
        }

        // Check if the book exists in the library
        if (!$library->books->contains($request->book_id)) {
            return $this->apiResponse(null, "Book not found in the library", 404);
        }

        // Detach the book from the library
        $library->books()->detach($request->book_id); /// the detach method is used to remove relationships between models in a many-to-many relationship. Specifically, it removes a record from the intermediate table that links two models in a many-to-many relationship.

        return $this->apiResponse(null, "Book removed from the library successfully", 200);
    }
}
