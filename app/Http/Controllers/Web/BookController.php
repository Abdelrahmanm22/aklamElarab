<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use App\Trait\AttachmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //
    use AttachmentTrait;
    public function index()
    {
        $book = Book::get();
        return view('book.index', compact('book'))->with('title', 'Book');
    }


    public function store()
    {
        $publishers = Publisher::get();
        $authors = User::where('type', '=', 'author')->select('id', 'name')->get();
        $categories = Category::get();
        return view('book.add', compact(['publishers', 'authors', 'categories']))->with('title', 'Add Book');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'description' => 'string|between:2,2000',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'file' => 'required|mimes:pdf',
            'trail' => 'required|mimes:pdf',
            'author' => 'required',
            'publisher' => 'required',
            'categories' => 'required|array', // Ensure 'categories' is an array
            'categories.*' => 'exists:categories,id', // Ensure each category id exists in the 'categories' table
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        ///move image and file
        $imageName = $this->saveAttach($request->image, 'Attachment/Books/Images/'. $request->author, $request->name);
        $fileName = $this->saveBook($request->file, 'Attachment/Books/Files/'. $request->author, $request->name);
        $trailName = $this->saveBook($request->trail, 'Attachment/Books/Trail/'. $request->author, $request->name);

        $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
            'file' => $fileName,
            'trail' => $trailName,
            'publisher_id' => $request->publisher,
            'author_id' => $request->author,
            'admin_id' => auth()->user()->id,
        ]);

        // Attach categories to the book
        $book->categories()->attach($request->categories);


        return redirect()->route('book')->with('success', 'Created Book Successfully');
    }


    public function delete(Request $request)
    {
        $book = Book::find($request->book_id);
        if (!$book) {
            return redirect()->route('book')->with('error', 'Book not found');
        }

        // Get the paths for image, file, and trail
        $imagePath = public_path('Attachment/Books/Images/' . $book->author_id . '/') . $book->image;
        $filePath = public_path('Attachment/Books/Files/' . $book->author_id . '/') . $book->file;
        $trailPath = public_path('Attachment/Books/Trail/' . $book->author_id . '/') . $book->trail;

        // Check if the files exist before attempting to delete them
        if (file_exists($imagePath)) {
            // Delete the image file
            unlink($imagePath);
        }

        if (file_exists($filePath)) {
            // Delete the file
            unlink($filePath);
        }

        if (file_exists($trailPath)) {
            // Delete the trail file
            unlink($trailPath);
        }

        $book->delete();

        return redirect()->route('book')->with('success', 'Deleted Book Successfully');
    }
}
