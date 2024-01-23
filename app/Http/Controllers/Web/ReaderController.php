<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    //
    public function index(){
        $readers = User::where('type','=','reader')->get();
        return view('reader.index',compact('readers'))->with('title','Readers');
    }

}
