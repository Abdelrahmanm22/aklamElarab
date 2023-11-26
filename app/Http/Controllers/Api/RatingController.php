<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RatingController extends Controller
{
    //
    public function getRating($reader_id,$book_id){
        $userRating = Rating::getUserRating($reader_id, $book_id);
        // Now you can use $userRating as needed
        if ($userRating) {
            // User rating found
            return $this->apiResponse($userRating,'User rating found',200); // Assuming there is a 
        } else {
            // User rating not found
            // Handle the case where the user hasn't rated the book
            return $this->apiResponse(0,'User rating Not found',200);
        }
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'rate' => 'required|integer|between:1,5',
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $rate = Rating::create([
            'rate'=>$request->rate,
            'book_id'=>$request->book_id,
            'reader_id'=>auth()->user()->id,
        ]);
        Book::updateAverageRating($request->book_id);
        return $this->apiResponse($rate, 'Rate Added successfully', 201);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'rate' => 'required|integer|between:1,5',
            'book_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }


        $rate=Rating::getUserRating(auth()->user()->id, $request->book_id);

        $rate->update([
            'rate'=>$request->rate,
        ]);
        Book::updateAverageRating($request->book_id);
        return $this->apiResponse($rate, 'Rate Updated successfully', 201);
    }
}
