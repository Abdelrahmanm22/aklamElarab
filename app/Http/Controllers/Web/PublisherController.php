<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    //
    public function index(){
        $publisher = Publisher::get();
        return view('publisher.index',compact('publisher'))->with('title','Publisher');
    }

    public function store(){
        return view('publisher.add')->with('title','Add Publisher');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        //check if data is not correct
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        Publisher::create([
            'name'=>$request->name,
        ]);

        return redirect()->route('publisher')->with('success', 'Created Publisher Successfully');
    }


    public function delete(Request $request){
        $publisher = Publisher::find($request->publisher_id);
        if (!$publisher) {
            return redirect()->route('publisher')->with('error', 'Publisher not found');
        }
    
        $publisher->delete();
    
        return redirect()->route('publisher')->with('success', 'Deleted Publisher Successfully');
    }
}
