<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{
    //
    public function show()
    {
        $title = "Ring Name";
        return view('frontend.products.test', compact('title'));
    }
    public function add(Request $request)
    {
        //dd($request);

        return $request->all();
    }
}
