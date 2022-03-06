<?php

namespace App\Http\Controllers\front\home;

use App\Http\Controllers\Controller;
use App\Logger;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
        $logger = Logger::orderBy('created_at', 'desc')->limit(10)->get();
        $arr = [
            'logger' => $logger
        ];
        return view('front.home.index', $arr);
    }
}
