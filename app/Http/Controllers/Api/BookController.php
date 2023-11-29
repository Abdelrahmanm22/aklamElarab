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
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')->get();
        return $this->apiResponse($books, 'ok', 200);
    }

    public function getLatest(){
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')
            ->latest() // Orders the results by the created_at column in descending order
            ->take(10)  // Retrieves only the latest 10 records
            ->get();

        return $this->apiResponse($books, 'ok', 200);
    }

    public function getHighestRate(){
        $books = Book::select('id', 'name', 'description', 'image', 'file', 'rate', 'created_at')
            ->orderBy('rate', 'desc') // Orders the results by the rate column in descending order (highest first)
            ->take(2)  // Retrieves only the top 10 highest rated books
            ->get();
        return $this->apiResponse($books, 'ok', 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'description' => 'string|between:2,1000',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'file' => 'required|mimes:pdf',
            'author_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        ///move image and file
        $imageName = $this->saveAttach($request->image, 'Attachment/Books/Images/' . $request->author_id);
        $fileName = $this->saveAttach($request->file, 'Attachment/Books/Files/' . $request->author_id);

        $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'file' => $fileName,
            'author_id' => $request->author_id,
            'admin_id' => auth()->user()->id,
        ]);

        return $this->apiResponse($book, 'Book Added successfully', 201);
    }

    ///function to get book with comments and its own reader
    public function getBook($id){
        $book = Book::with('comments.reader')->find($id);
        return $this->apiResponse($book, 'ok', 200);
    }

    ///this function to increase views for book after bass on day
    public function open($id){    
        $view = Bookview::where('book_id', $id)
            ->where('reader_id', auth()->user()->id)
            ->first();

        if ($view) {
            return $this->apiResponse(0, 'Views do not increase because not a day has passed', 200);
        } else {
            $expirationDate = Carbon::now()->addMinutes(5);
            Bookview::create([
                'book_id' => $id,
                'reader_id'=>auth()->user()->id,
                'expiration_date' => $expirationDate,
            ]);
            Book::incrementView($id);
            return $this->apiResponse(1, 'Views increased by 1', 200);
        }
    }
}
