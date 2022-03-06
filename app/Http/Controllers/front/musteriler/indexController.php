<?php

namespace App\Http\Controllers\front\musteriler;

use App\FaturaIslem;
use App\Helper\fileUpload;
use App\Http\Controllers\Controller;
use App\Islem;
use App\Logger;
use App\Musteriler;
use App\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    public function index()
    {
        return view('front.musteriler.index');
    }

    public function create()
    {
        return view('front.musteriler.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');

        $all['photo'] = fileUpload::newUpload(rand(1,9000), 'musteriler', $request->file('photo'), 0);
        $create = Musteriler::create($all);

        if ($create)
        {
            Logger::Insert($all[0]['ad'].' '.$all[0]['ad'].' müşterisi eklendi.','Müşteri');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
        }
        else
            return redirect()->back()->with('status', 'Ekleme işlemi gerçekleştirilemedi.');

    }

    public function edit($id)
    {
        $c = Musteriler::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Musteriler::where('id', $id)->get();
            return view('front.musteriler.edit', compact('data'));
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = Musteriler::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            $data =  Musteriler::where('id', $id)->get();
            $all['photo'] = fileUpload::changeUpload(rand(1,9000), 'musteriler', $request->file('photo'), 0, $data, 'photo');

            $update = Musteriler::where('id', $id)->update($all);

            if ($update)
            {
                Logger::Insert(Musteriler::getPublicName($data[0][$id]).' müşterisi düzenlendi.','Müşteri');
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
        $c = Musteriler::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Musteriler::where('id', $id)->get();
            Logger::Insert(Musteriler::getPublicName($data[0]['id']).' müşteri silindi.', 'Müşteri');
            fileUpload::directoryDelete($data[0]['photo']);
            fileUpload::directoryDelete($data[0]['photo']);
            Musteriler::where('id', $id)->delete();
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function extre($id)
    {
        $c = Musteriler::where('id', $id)->count();

        if ($c !=0)
        {
            $data = Musteriler::where('id', $id)->get();
            $faturaTablo = FaturaIslem::leftJoin('faturas', 'fatura_islems.faturaId', '=', 'faturas.id')
                                        ->where('faturas.musteriId', $id)
                                        ->groupBy('faturas.id')
                                        ->orderBy('faturas.faturaTarih', 'DESC')
                                        ->select(['faturas.id as id','faturas.faturaTipi as type' , DB::raw('"fatura" as uType'), DB::raw('SUM(genelToplam) as fiyat'), 'faturas.faturaTarih as tarih']);

            $islemTablo = Islem::where('musteriId', $id)
                                ->orderBy('tarih', 'DESC')
                                ->select(['id', 'tip as type', DB::raw('"islem" as uType'), 'fiyat', 'tarih']);
            $viewData = $faturaTablo->union($islemTablo)
                ->orderBy('tarih', 'DESC')->get();
                $arr = [
                    'data'=>$data,
                    'viewData'=>$viewData
                ];
            return view('front.musteriler.extre', $arr);
        }
        else
            return abort(404);
    }

    public function data(Request $request)
    {
        $table = Musteriler::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
              return '<a href="'.route('musteriler.edit', ['id'=>$table]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('musteriler.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->addColumn('publicname', function ($table){
                return Musteriler::getPublicName($table->id);
            })
            ->addColumn('bakiye', function ($table){
                $bakiye = Rapor::getMusteriBakiye($table->id);
                if ($bakiye < 0)
                {
                    return '<span style="color: red;"> -'.$bakiye.' TL</span>';
                }
                elseif($bakiye > 0)
                    return '<span style="color: green;"> +'.$bakiye.' TL</span>';
                else
                    return $bakiye;
            })
            ->addColumn('extre', function ($table){
                return '<a href="'.route('musteriler.extre', ['id'=>$table]).'">Extre</a>';
            })
            ->editColumn('musteriTipi', function ($table){
                if ($table->musteriTipi == 0) { return 'Bireysel';} else { return 'Kurumsal';}
            })
            ->rawColumns(['edit', 'delete', 'bakiye', 'extre'])
            ->make(true);
        return $data;
    }
}
