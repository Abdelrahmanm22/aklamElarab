<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CommentController extends Controller
{
    //
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:10000',
            'book_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $comment = Comment::create([
            'text'=>$request->text,
            'book_id'=>$request->book_id,
            'reader_id'=>auth('api')->user()->id,
        ]);

        return $this->apiResponse($comment, 'Comment Added successfully', 201);
    }
}
