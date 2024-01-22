<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    //
    public function index(){
        $adv = Advertisement::get();
        return $this->apiResponse($adv,"Get Advertisement Successfully",200);
    }
}
