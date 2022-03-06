<?php

namespace App\Http\Controllers\front\urun;

use App\Http\Controllers\Controller;
use App\Logger;
use App\Urun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //

    public function index()
    {
        return view('front.urun.index');
    }

    public function create()
    {
        return view('front.urun.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Urun::create($all);

        if ($create)
        {
            Logger::Insert($all['urunAdi'].' Ürünü eklendi.', 'Ürün');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
        }
        else
            return redirect()->back()->with('status', 'Ekleme işlemi gerçekleştirilemedi.');

    }

    public function edit($id)
    {
        $c = Urun::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Urun::where('id', $id)->get();
            return view('front.urun.edit', compact('data'));
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Urun::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            $data =  Urun::where('id', $id)->get();

            $update = Urun::where('id', $id)->update($all);

            if ($update)
            {
                Logger::Insert($data[0]['urunAdi'].' ürünü düzenlendi.', 'Ürün');
                return redirect()->back()->with('status', 'Güncelleme işlemi başarılı bir şekilde gerçekleştirildi.');
            }
            else
                return redirect()->back()->with('status', 'Güncelleme işlemi gerçekleştirilemedi.');
        }
        else
            return redirect('/');
    }

    public function delete($id)
    {
        $c = Urun::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Urun::where('id', $id)->get();
            Urun::where('id', $id)->delete();
            Logger::Insert($data[0]['ad'].' ürünü silindi.', 'Kalem');
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = Urun::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('urun.edit', ['id'=>$table]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('urun.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
