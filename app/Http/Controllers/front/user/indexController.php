<?php

namespace App\Http\Controllers\front\user;

use App\FaturaIslem;
use App\Http\Controllers\Controller;
use App\Logger;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class indexController extends Controller
{
    //

    public function __construct()
    {
        dd('asdasd');
    }

    public function index()
    {
        return view('front.user.index');
    }

    public function create()
    {
        return view('front.user.create');
    }

    public function store(Request $request)
    {
        $all = $request->except('_token');
        $c = User::where('email', $all['email'])->count();
        if ($c == 0)
        {
            $permission = (isset($all['permission'])) ? $all['permission'] : [];
            unset($all['permission']);
            $all['password'] = md5($all['password']);
            $create = User::create($all);

            if ($create)
            {
                if (count($permission) != 0)
                {
                    foreach ($permission as $k => $v)
                    {
                        UserPermission::create([
                            'userId' => $create->id,
                            'permissionId' => $v
                        ]);
                    }
                }
                Logger::Insert($all['name'].' adlı kullanıcı eklendi.', 'User');
                return redirect()->back()->with('status', 'Başarılı bir şekilde ekleme işlemi gerçekleştirildi.');
            }
            else
                return redirect()->back()->with('status', 'Ekleme işlemi gerçekleştirilemedi.');

        }
        else
            return redirect()->back()->with('statusDanger', 'Email sistemde mevcut.');

    }

    public function edit($id)
    {
        $c = User::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  User::where('id', $id)->get();
            return view('front.user.edit', compact('data'));
        }
        else
            return redirect('/');
    }

    public function update(Request $request)
    {
        $id = $request->route('id');
        $c = User::where('id', $id)->count();
        if ($c !=0)
        {
            $all = $request->except('_token');
            if ($all['password'] == '')
                unset($all['password']);
            else
                $all['password'] = md5($all['password']);

            $emailControl = User::where('email', $all['email'])->where('id', '!=', $id)->count();
            if ($emailControl != 0)
                return redirect()->back()->with('statusDanger', 'Email adresi sistemde mevcut');

            $permission = (isset($all['permission'])) ? $all['permission'] : [];

            UserPermission::where('userId', $id)->delete();
            if (count($permission)!=0)
            {
                foreach ($permission as $k => $v) {
                    UserPermission::create([
                        'userId'=>$id,
                        'permissionId' => $v
                    ]);
                }
            }
            unset($all['permission']);

            $data =  User::where('id', $id)->get();
            $update = User::where('id', $id)->update($all);

            if ($update)
            {
                Logger::Insert($data[0]['name'].' adlı kullanıcı düzenlendi.', 'User');
                return redirect()->back()->with('status', 'Güncelleme işlemi başarılı bir şekilde gerçekleştirildi.');
            }
            else
                return redirect()->back()->with('statusDanger', 'Güncelleme işlemi gerçekleştirilemedi.');
        }
        else
            return redirect('/');
    }

    public function delete($id)
    {
        $c = User::where('id', $id)->count();
        if ($c !=0)
        {
            $data =  User::where('id', $id)->get();
            User::where('id', $id)->delete();
            Logger::Insert($data[0]['name'].' adlı kullanıcı silindi.', 'User');
            return redirect()->back();
        }
        else
            return redirect('/');
    }

    public function data(Request $request)
    {
        $table = User::query();
        $data = DataTables::of($table)
            ->addColumn('edit', function ($table){
                return '<a href="'.route('user.edit', ['id'=>$table]).'">Düzenle</a>';
            })

            ->addColumn('delete', function ($table){
                return '<a href="'.route('user.delete', ['id'=>$table]).'">Delete</a>';
            })
            ->rawColumns(['edit', 'delete'])
            ->make(true);
        return $data;
    }
}
