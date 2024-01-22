<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    //

    ///this function to check if found record for page mark or not
    public function open($bookId){
        
        $mark = Mark::where('book_id',$bookId)
        ->where('reader_id',auth('api')->user()->id)->first();
    
        if($mark){
            return $this->apiResponse($mark->page,"Get Page Mark Successfully",200);
        }else{
            // Create a new record if it doesn't exist
            $newMark = Mark::create([
                'book_id'=>$bookId,
                'reader_id'=>auth('api')->user()->id,
                'page'=>0,
            ]);
            
             // Return the created mark page
             return $this->apiResponse($newMark->page, "Get Page Mark Successfully", 200);
        }
    }

    ///this function to receive newMark page
    public function close(Request $request){
        $mark = Mark::where('book_id',$request->bookId)
        ->where('reader_id',auth('api')->user()->id)->first();

        $mark->update([
            'page'=>$request->page,
        ]);
        return $this->apiResponse($mark->page, "Page Mark Updated Successfully", 200);
    }


}
