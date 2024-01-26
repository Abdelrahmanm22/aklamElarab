<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\AttachmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    use AttachmentTrait;
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'birthDate'=> 'nullable|date',
            'gender' => ['in:0,1,2'], // 0: female, 1: male, 2: another gender
            'phone'=>'numeric',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }

        
        ///gender validate
        $gender=null;
        if($request->gender!=null){
            
            if($request->gender==1){
                $gender="male";
            }elseif ($request->gender==0){
                $gender="female";
            }
        }
        ///gender validate



        $user = User::find(auth('api')->user()->id);
        // return $user;
        $user->update([
            'name'=>$request->name,
            // 'email'=>$request->email,
            'birthDate'=>$request->birthDate,
            'gender'=>$gender,
            'phone'=>$request->phone,
        ]);

        return $this->apiResponse($user,"Update Info Successfully",200);
    }

    public function updateImage(Request $request){
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        
        //to delete last image
        $user = User::find(auth('api')->user()->id);
        
            // Get the image path
            $imagePath = public_path('Attachment/Users/Authors/') . $user->photo;
            // return $imagePath;
            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath) and $user->photo!=null) {
            // Delete the image file
                unlink($imagePath);
            }    
            
        $imageName = $this->saveAttach($request->photo,"Attachment/Users/Authors/");
        
        $user->update([
            'photo'=>$imageName,
        ]);
        return $this->apiResponse($user,"Update Photo Successfully",200);
    }
}
