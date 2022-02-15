<?php

namespace App\Http\Controllers\front\musteriler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index()
    {
    }
    public function create()
    {
        return view('front.musteriler.create');
    }
    public function store(Request $request)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request)
    {
    }
    public function delete($id)
    {
    }
}
