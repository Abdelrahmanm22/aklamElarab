<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Library;
use App\Models\Related;
use App\Models\User;
use App\Trait\AttachmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    use AttachmentTrait;
    public function index(){
        $authors = User::where('type','=','author')->get();
        return view('author.index',compact(['authors']))->with('title','Authors');
    }

    public function store(){
        return view('author.add')->with('title','Add Author');
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'birthDate'=> 'required|date',
            'gender' => ['required', 'in:0,1'], // male:1 -- female 0
            'phone'=>'required|numeric',
            'photo'=>'image|mimes:jpeg,png,jpg,gif',
            'about'=> 'max:2000',
            'facebook'=>'',
            'twitter'=>'',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        ///check if found photo
        $imageName = null;
        if($request->photo){
            $imageName = $this->saveAttach($request->photo,"Attachment/Users/");
        }


        $Gender = ($request->gender==1)?"male":"female";

        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'type' => 'author',
                'birthDate'=>$request->birthDate,
                'gender'=>$Gender,
                'phone'=>$request->phone,
                'photo'=>$imageName,
            ]
        ));

        //create library for author in application
        Library::createLibrary($user->id);

        Related::create([
            'author_id'=>$user->id,
            'facebook'=>$request->facebook,
            'twitter'=>$request->twitter,
            'about'=>$request->about,
        ]);

        return redirect()->route('author')->with('success', 'Created Author Successfully');
    }

    public function edit($id){

        $author = User::with('related','books')->find($id);
        if(!$author){
            return redirect()->route('author')->with('error', 'Author not found');
        }

        // return $author;

        return view('author.edit',compact('author'))->with('title','Author Profile');
    }
}
