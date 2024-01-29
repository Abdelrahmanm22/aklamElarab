<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Bookview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Trait\AttachmentTrait;
use Carbon\Carbon;

class BookController extends Controller
{
    //
    use AttachmentTrait;

    public function index(){
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')
            ->paginate(20); // You can specify the number of items per page, for example, 10.


        
        $response = [
            'data' => $books->items(),
            'message' => 'ok',
            'status' => 200,
            'last_page' => $books->lastPage(),
            'per_page' => $books->perPage(),
            'current_page' => $books->currentPage(),
        ];
        return response()->json($response);
    }

    public function getLatest()
    {
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')
            ->latest() // Orders the results by the created_at column in descending order
            ->take(10)  // Retrieves only the latest 10 records
            ->get();

        return $this->apiResponse($books, 'ok', 200);
    }

    public function getHighestRate()
    {
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')
            ->orderBy('rate', 'desc') // Orders the results by the rate column in descending order (highest first)
            ->take(10)  // Retrieves only the top 10 highest rated books
            ->get();
        return $this->apiResponse($books, 'ok', 200);
    }



    ///function to get book with comments and its own reader and and publisher
    public function getBook($id)
    {
        $book = Book::with(['comments.reader', 'author', 'publisher'])->find($id);
        return $this->apiResponse($book, 'ok', 200);
    }

    ///this function to increase views for book after pass one day
    public function open($id)
    {
        $view = Bookview::where('book_id', $id)
            ->where('reader_id', auth('api')->user()->id)
            ->first();

        if ($view) {
            return $this->apiResponse(0, 'Views do not increase because not a day has passed', 200);
        } else {
            $expirationDate = Carbon::now()->addMinutes(5);
            Bookview::create([
                'book_id' => $id,
                'reader_id' => auth('api')->user()->id,
                'expiration_date' => $expirationDate,
            ]);
            Book::incrementView($id);
            return $this->apiResponse(1, 'Views increased by 1', 200);
        }
    }
}
