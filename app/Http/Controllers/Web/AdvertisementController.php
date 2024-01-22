<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Trait\AttachmentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdvertisementController extends Controller
{
    //
    use AttachmentTrait;
    public function index()
    {
        $advertisement = Advertisement::get();
        return view('advertisement.index', compact('advertisement'))->with('title', 'Advertisement');
    }

    public function store()
    {
        return view('advertisement.add')->with('title', 'Add Advertisement');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ]);


        //check if data is not correct
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $imageName = $this->saveAttach($request->image, 'Attachment/Advertisement/');
        
        Advertisement::create([
            'img' => $imageName,
            'admin_id'=>auth()->user()->id,
        ]);

        return redirect()->route('advertisement')->with('success', 'Created Advertisement Successfully');
    }


    public function delete(Request $request)
    {
        $advertisement = Advertisement::find($request->advertisement_id);
        if (!$advertisement) {
            return redirect()->route('advertisement')->with('error', 'Advertisement not found');
        }

        // Get the image path
        $imagePath = public_path('Attachment/Advertisement/') . $advertisement->img;

        // Check if the file exists before attempting to delete it
        if (file_exists($imagePath)) {
            // Delete the image file
            unlink($imagePath);
        }

        $advertisement->delete();

        return redirect()->route('advertisement')->with('success', 'Deleted Advertisement Successfully');
    }
}
