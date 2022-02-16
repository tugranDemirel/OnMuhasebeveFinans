<?php
namespace App\Helper;
use File;
use Image;
class fileUpload{

    static function newUpload($name, $directory, $file, $type = 0)
    {
        if (!empty($file))
        {
            $dir = 'image/'.$directory.'/'.$name;
            if (!File::exists($dir))
            {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = rand(1,90000).'.'.$file->getClientOriginalExtension();
            if ($type == 0)
            {
    //             0 ise resim yukleme
                $path = public_path($dir.'/'.$filename);
                Image::make($file->getRealPath())->save($path);
            }
            else
            {
    //            1 ise resim dışında pdf video vs yükleme
                $path = public_path($dir.'/'.$filename);
                $file->move($path, $filename);
            }
            return $dir.'/'.$filename;

        }
        else
            return "";
    }

    static function changeUpload($name, $directory, $file, $type = 0, $data, $field)
    {
        if (!empty($file)) {
            $dir = 'image/'.$directory.'/'.$name;
            if (!File::exists($dir))
            {
                File::makeDirectory($dir, 0755, true);
            }
            $filename = rand(1,90000).'.'.$file->getClientOriginalExtension();
            if ($type == 0)
            {
                //             0 ise resim yukleme
                $path = public_path($dir.'/'.$filename);
                Image::make($file->getRealPath())->save($path);
            }
            else
            {
                //            1 ise resim dışında pdf video vs yükleme
                $path = public_path($dir.'/'.$filename);
                $file->move($path, $filename);
            }
            if (self::folderFounder($data[0][$field]) !="")
            {
                File::deleteDirectory(public_path(self::folderFounder($data[0][$field])));
            }
            return $dir.'/'.$filename;
        }
        else
        {
            return $data[0][$field];
        }
    }

//    Resim dosyasi yolunu parcalama
    static function folderFounder($filename)
    {
        $explode = explode('/', $filename);
//        ucuncu kismi kaldir dedik
        unset($explode[3]);
        return implode('/', $explode);
    }

    static function directoryDelete($filePath)
    {
        if (self::folderFounder($filePath) != "")
        {
            File::deleteDirectory(public_path(self::folderFounder($filePath)));
        }
    }
}
