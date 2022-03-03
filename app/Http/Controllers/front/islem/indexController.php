<?php

namespace App\Http\Controllers\front\islem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    //
    public function create($type)
    {
        if($type == 0)
            return view('front.islem.odeme.create'); // odeme
        elseif ($type == 1)
            return view('front.islem.tahsilat.create'); // tahsilate
        else
            return abort(404);
    }
}
