<?php

namespace App\Http\Controllers\front\kalem;

use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Kalem;
use App\Logger;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.kalem.index');
    }

    public function create()
    {
        return view('front.kalem.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Kalem::create($all);

        if ($create)
        {
            Logger::Insert($all['ad'].' Kalemi eklendi.', 'Kalem');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
        }
        else
            return redirect()->back()->with('status', 'Ekleme işlemi gerçekleştirilemedi.');

    }

    public function edit($id)
    {
        $c = Kalem::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Kalem::where('id', $id)->get();
            return view('front.kalem.edit', compact('data'));
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Kalem::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            $data =  Kalem::where('id', $id)->get();

            $update = Kalem::where('id', $id)->update($all);

            if ($update)
            {
                Logger::Insert($data[0]['ad'].' kalemi düzenlendi.', 'Kalem');
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
        $c = Kalem::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Kalem::where('id', $id)->get();
            Kalem::where('id', $id)->delete();
            Logger::Insert($data[0]['ad'].' kalemi silindi.', 'Kalem');
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = Kalem::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('kalem.edit', ['id'=>$table]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('kalem.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->editColumn('kalemTipi', function ($table){
                if ($table->kalemTipi == 0) { return 'Gelir';} else { return 'Gider';}
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
