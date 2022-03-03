<?php

namespace App\Http\Controllers\front\islem;

use App\Http\Controllers\Controller;
use App\Islem;
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

    public function store(Request $request)
    {
        $all = $request->except('_token');
        $type = $request->route('type');

        $all['tip'] = $type;
        $create = Islem::create($all);
        if ($create)
            return redirect()->back()->with('status', 'Başarılı bir şekilde ödeme işlemi alındı');
        else
            return redirect()->back()->with('statusDanger', 'Ödeme işlemi gerçekleştirilemedi');
    }
}
