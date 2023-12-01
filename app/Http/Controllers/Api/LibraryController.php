<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    //

    public function index(){
        $library = Library::where('reader_id',auth()->user()->id)->first();
        return $this->apiResponse($library->books,"ok",200);
    }

    public function OpenBooKToLibrary($id){
        
        $library = Library::where('reader_id',auth()->user()->id)->first();

        
        if($library->books->contains($id)){
            return $this->apiResponse(null,"Book is already in the library",200);
        }
        
        
        $library->books()->attach($id);

        return $this->apiResponse(null,"Book Added To Library Successfully",200);
    }
}
