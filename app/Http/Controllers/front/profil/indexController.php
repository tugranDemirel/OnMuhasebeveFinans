<?php

namespace App\Http\Controllers\front\profil;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    //
    public function index()
    {
        return view('front.profil.index');
    }

    public function update(Request $request)
    {
        $all = $request->except('_token');
        if ($all['password'] == '')
        {
            unset($all['password']);
        }
        else
            $all['password'] = md5($all['password']);

        $data = User::where('id', Auth::id())->get();
        $all['photo'] = fileUpload::changeUpload(rand(1,1000), 'profil', $request->file('photo'), 0, $data, 'photo');
        $update = User::where('id', Auth::id())->update($all);
        if ($update)
        {
            return redirect()->back()->with('status', 'Güncelleme işlemi başarılı bir şekilde gerçekleştirildi');
        }
        else
            return redirect()->back()->with('statusDanger', 'Güncelleme işlemi gerçekleştirilemedi');
    }
}
