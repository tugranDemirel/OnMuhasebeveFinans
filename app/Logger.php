<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    //
    protected $guarded = [];

    /**
     * @param Insert = Ne tur islemleri yaptik onlarin kayidini tutmak icin olusturdugumuz fonksiyon
     * @param $text = ne islemi yaptik o
     * @param $islem = yapacagimiz islem
     */
    static function Insert($text, $islem)
    {
        Logger::create(['text'=>$text, 'islem'=>$islem]);
    }
}
