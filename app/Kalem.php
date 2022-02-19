<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kalem extends Model
{
    //
    protected $guarded = [];

    static function getList($type)
    {
        /*
         *  Gelir gider kısımlarını ayrı ayrı listelemek için olusturulmuş
         *  bir fonksiyondur
         *  $tpye : gelir mi gider mi sorusunun cevabini verecek olan parametre
         * */

        $list = Kalem::where('kalemTipi', $type)->get();
        return $list;
    }
}
