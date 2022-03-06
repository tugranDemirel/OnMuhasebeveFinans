<?php

namespace App\Http\Controllers\front\islem;

use App\Fatura;
use App\Http\Controllers\Controller;
use App\Islem;
use App\Logger;
use App\Musteriler;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //
    public function index()
    {
        return view('front.islem.index');
    }

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
        {
            if ($type == ISLEM_ODEME)
                Logger::Insert('Ödeme yapıldı', 'İşlem');
            else
                Logger::Insert('Tahsilat yapıldı', 'İşlem');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ödeme işlemi alındı');
        }
        else
            return redirect()->back()->with('statusDanger', 'Ödeme işlemi gerçekleştirilemedi');
    }

    public function edit($id)
    {
        $c = Islem::where('id', $id)->count();
        if ($c != 0)
        {
            $w = Islem::where('id', $id)->get();
            if ($w[0]['tip'] == 0)
            {
                return view('front.islem.odeme.edit', ['data'=>$w]);
            }
            elseif($w[0]['tip'] == 1)
                return view('front.islem.tahsilat.edit', ['data'=>$w]);
            else
                return abort(404);
        }
        else
            return redirect()->back()->with('statusDanger', 'Böyle bir kayıt bulunamadı');
    }
    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Islem::where('id', $id)->count();
        if ($c != 0)
        {
            $all = $request->except('_token');
            $update = Islem::where('id', $id)->update($all);
            $data = Islem::where('id', $id)->get();
            if ($update != 0)
            {
                if ($data[0]['tip'] == ISLEM_ODEME)
                    Logger::Insert('Ödeme düzenlendi.', 'İşlem');
                else
                    Logger::Insert('Tahsilat düzenlendi.', 'İşlem');
                return redirect()->back()->with('status', 'Güncelleme işlemi başarılı bir şekilde gerçekleştirildi');
            }
            else
                return redirect()->back()->with('statusDanger', 'Böyle bir kayıt bulunamadı');
        }
        else
            return redirect()->back()->with('statusDanger', 'İşlem gerçekleştirilemedi');
    }

    public function delete($id)
    {
        $c = Islem::where('id', $id)->count();
        if ($c != 0)
        {
            $data = Islem::where('id',$id)->get();
            $w = Islem::where('id', $id)->delete();
            if ($w)
            {
                if ($data[0]['tip'] == ISLEM_ODEME)
                    Logger::Insert('Ödeme silindi', 'İşlem');
                else
                    Logger::Insert('Tahsilat silindi.', 'İşlem');
                return redirect()->back()->with('status', 'Başarılı bir şekilde silme işlemi gerçekleştirildi.');
            }
            else
                return redirect()->back()->with('statusDanger', 'İşlem gerçekleştirilemedi.');
        }
        else
            return abort(404);
    }

    public function data(Request $request)
    {
        $table = Islem::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('islem.edit', ['id'=>$table->id]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('islem.delete', ['id'=>$table->id]).'">Delete</a>';
            })
            ->addColumn('faturaNo', function ($table){
                return Fatura::getNo($table->faturaId);
            })
            ->addColumn('musteri', function ($table){
                return Musteriler::getPublicName($table->musteriId);
            })
            ->editColumn('tip', function ($table){
                if ($table->tip == 0) { return 'Ödeme';} else { return 'Tahsilat';}
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
