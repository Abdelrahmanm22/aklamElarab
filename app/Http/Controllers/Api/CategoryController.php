<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Trait\ApiResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    use ApiResponseTrait;
    public function index(){
        $categories = Category::get();
        return $this->apiResponse($categories,"Get Categories Successfully",200);
    }

    ///function to get category with its books by category ID
    public function getCategory($id){
        $category = Category::with('books')->find($id);
        if($category){
            return $this->apiResponse($category,'Get Category Successfully',200);
        }else{
            return $this->apiResponse(null,"Not Found Category with this ID",404);
        }
    }
}
