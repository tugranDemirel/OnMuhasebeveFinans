<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    static function FaturaHatirlatici()
    {
        $returnArray =[];
        if (Fatura::count() != 0)
        {
            $list = Fatura::all();
            foreach ($list as  $k => $v)
            {
                if ($v['faturaTipi'] == FATURA_GELIR)
                {
                    $c = Islem::where('tip', ISLEM_TAHSILAT)->where('faturaId', $v['id'])->count();
                    $type = 'Gelir Faturası';
                    $uri = route('islem.create', ['type'=>ISLEM_TAHSILAT]);
                }
                elseif ($v['faturaTipi'] == FATURA_GIDER)
                {
                    $c = Islem::where('tip', ISLEM_ODEME)->where('faturaId', $v['id'])->count();
                    $type = 'Gider Faturası';
                    $uri = route('islem.create', ['type'=>ISLEM_ODEME]);
                }
                else
                    return 'Bildirim Yok';
                if ($c == 0)
                {
                    $returnArray[$k]['name'] = $v['faturaNo'].' - '.$type;
                    $returnArray[$k]['musteriId'] = $v['musteriId'];
                    $returnArray[$k]['fiyat'] = Fatura::getTotal($v['id']);
                    $returnArray[$k]['uri'] = $uri;
                }
            }
        }
        return $returnArray;
    }
}
