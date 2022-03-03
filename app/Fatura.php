<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $guarded = [];

    static function getList($type)
    {
        return Fatura::where('faturaTipi', $type)->get();
    }
    static function getTotal($id)
    {
        return FaturaIslem::where('faturaId', $id)->sum('genelToplam');
    }
}
