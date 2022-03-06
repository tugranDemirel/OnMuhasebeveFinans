<?php

namespace App\Http\Controllers\front\banka;

use App\Banka;
use App\Http\Controllers\Controller;
use App\Logger;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //
    public function index()
    {
        return view('front.banka.index');
    }

    public function create()
    {
        return view('front.banka.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $create = Banka::create($all);

        if ($create)
        {
            Logger::Insert('Yeni ekleme yapıldı', 'Banka');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
        }
        else
        {
            Logger::Insert('Yeni ekleme yapılamadı', 'Banka');
            return redirect()->back()->with('statusDanger', 'Ekleme işlemi gerçekleştirilemedi.');
        }

    }

    public function edit($id)
    {
        $c = Banka::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Banka::where('id', $id)->get();
            return view('front.banka.edit', compact('data'));
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Banka::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            $bankName = Banka::where('ad', $all['ad'])->count();
            if (!$bankName)
            {
                $data =  Banka::where('id', $id)->get();
                $update = Banka::where('id', $id)->update($all);

                if ($update)
                {
                    Logger::Insert($data[0]['ad'].' düzenlendi.','Banka');
                    return redirect()->back()->with('status', 'Güncelleme işlemi başarılı bir şekilde gerçekleştirildi.');
                }
                else
                {
                    Logger::Insert($data[0]['ad'].' düzenlenemedi.','Banka');
                    return redirect()->back()->with('statusDanger', 'Güncelleme işlemi gerçekleştirilemedi.');
                }
                    return redirect()->back()->with('statusDanger', 'Güncelleme işlemi gerçekleştirilemedi.');
            }
            else
            {
                Logger::Insert($bankName.' isminde başka bir banka mevcut.','Banka');
                return redirect()->back()->with('statusDanger', 'Aynı isime sahip banka adı mevcut.');
            }

        }
        else
        {
            return redirect('/');
        }
    }

    public function delete($id)
    {
        $c = Banka::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Banka::where('id', $id)->get();
            Banka::where('id', $id)->delete();
            Logger::Insert($data[0]['ad'].' silindi.','Banka');
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = Banka::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('banka.edit', ['id'=>$table]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('banka.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
