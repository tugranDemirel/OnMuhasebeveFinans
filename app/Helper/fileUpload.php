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
            return $dir.'/'.$filename;
        }
        else
        {
            return $data[0][$field];
        }
    }
}
