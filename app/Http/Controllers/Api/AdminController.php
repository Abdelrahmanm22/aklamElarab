<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Trait\AttachmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    use AttachmentTrait;
    public function addAuthor(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'type' => 'author',
            ]
        ));
        return $this->apiResponse($user,'Author Added successfully',201);
    }

    public function getAllUsers(){
        $users = User::where('id', '!=', auth()->user()->id)->get();
        return $this->apiResponse($users,'ok',200);
    }

    public function getAuthors(){
        $auhtors = User::where('type','=','author')->get();
        return $this->apiResponse($auhtors,'ok',200);
    }
    
    

    
}
