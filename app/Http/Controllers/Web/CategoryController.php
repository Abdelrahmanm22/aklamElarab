<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //

    public function index(){
        $category = Category::get();
        return view('category.index',compact('category'))->with('title','Category');
    }

    public function store(){
        return view('category.add')->with('title','Add Category');
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        //check if data is not correct
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        Category::create([
            'name'=>$request->name,
        ]);

        return redirect()->route('category')->with('success', 'Created Category Successfully');
    }


    public function delete(Request $request){
        $category = Category::find($request->category_id);
        if (!$category) {
            return redirect()->route('category')->with('error', 'Category not found');
        }
    
        $category->delete();
    
        return redirect()->route('category')->with('success', 'Deleted Category Successfully');
    }
}