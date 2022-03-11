<?php

namespace App\Http\Controllers\front\teklif;

use App\Http\Controllers\Controller;
use App\Logger;
use App\Musteriler;
use App\Teklif;
use App\TeklifIcerik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //
    public function index()
    {
        return view('front.teklif.index');
    }

    public function create()
    {
        return view('front.teklif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'fiyat'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'musteriId'=>'required|integer',
            'urunler'=>'required'
        ]);
        $all = $request->except('_token');
        $urunler = $all['urunler'];
        unset($all['urunler']);

        $userId = Auth::id();
        $create = Teklif::create($all);

        if ($create)
        {
            foreach ($urunler as $k => $v)
            {
                TeklifIcerik::create([
                    'teklifId' => $create->id,
                    'urunId' => $v['urunId'],
                    'adet' =>$v['adet']
                ]);
            }
            Logger::Insert(' Teklifi eklendi.', 'Teklif');
            return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
        }
        else
            return redirect()->back()->with('status', 'Ekleme işlemi gerçekleştirilemedi.');

    }

    public function edit($id)
    {
        $c = Teklif::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  Teklif::where('id', $id)->get();
            $content = TeklifIcerik::where('teklifId', $id)->get();
            $arr = [
              'data' => $data,
              'content' => $content
            ];
            return view('front.teklif.edit', $arr);
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $request->validate([
            'fiyat'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'musteriId'=>'required|integer',
            'urunler'=>'required'
        ]);
        $id = $request->route('id');
        $c = Teklif::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            $urunler = $all['urunler'];
            unset($all['urunler']);
//            Teklif icerigi
            TeklifIcerik::where('teklifId', $id)->delete();
            foreach ($urunler as $k =>$v)
            {
                TeklifIcerik::create([
                    'teklifId' => $id,
                    'urunId' => $v['urunId'],
                    'adet' =>$v['adet']
                ]);
            }

            $update = Teklif::where('id', $id)->update($all);

            if ($update)
            {
                Logger::Insert('Teklif düzenlendi.', 'Teklif');
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
        $c = Teklif::where('id', $id)->count();
        if ($c !=0)
        {
            Teklif::where('id', $id)->delete();
            Logger::Insert('Teklif silindi.', 'Teklif');
            TeklifIcerik::where('teklifId', $id)->delete();
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = Teklif::query();
        $data = DataTables::of($table)
            ->addColumn('musteri', function ($table){
                return Musteriler::getPublicName($table->musteriId);
            })
            ->addColumn('edit', function ($table){
                return '<a href="'.route('teklif.edit', ['id'=>$table]).'">Düzenle</a>';
            })
            ->addColumn('delete', function ($table){
                return '<a href="'.route('teklif.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->editColumn('status', function ($table){
                return ($table->status == 0) ? 'Bekleyen' : 'Onaylanmış';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
