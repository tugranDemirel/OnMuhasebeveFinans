<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    //
    static function getOdeme()
    {
        return Islem::where('tip', ISLEM_ODEME)->sum('fiyat');
    }
    static function getTahsilat()
    {
        return Islem::where('tip', ISLEM_TAHSILAT)->sum('fiyat');
    }
}
