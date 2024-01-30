<?php

namespace App;


use Intervention\Image\Facades\Image;

class MediaHelper
{

    const DEFAULT_WIDTH = 550;
    const DEFAULT_HEIGHT = 550;


    public static function resizeImage($src_image, $dst_image, $width, $height, $mark=false){
        if(!list($w, $h) = getimagesize($src_image)) return "Unsupported picture type!";

        $img = Image::make($src_image);
        if($w <= $h){
            $img->resize(null, $height, function($constraint){
                $constraint->aspectRatio();
            });
        }
        else{
            $img->resize($width, null, function($constraint){
                $constraint->aspectRatio();
            });
        }
        if($mark)
            $img->insert(public_path('images/watermark.png'), 'bottom-right', 10, 10);
        $img->save($dst_image);
        return true;

    }

    public static function proccessTmp($id, $property){
        $src = MediaHelper::findFile($id);
        if(!$src)
            return false;
        $ext = substr($src,strlen($src)-4);
        MediaHelper::ensureDirExists(public_path('images/properties/'.$property.'/'));
        $dst = public_path('images/properties/'.$property.'/');
        MediaHelper::resizeImage($src, $dst.$id.$ext,
            MediaHelper::DEFAULT_WIDTH, MediaHelper::DEFAULT_HEIGHT, true);
        MediaHelper::ensureDirExists($dst.'30/');
        MediaHelper::resizeImage($src, $dst.'30/'.$id.$ext,
            MediaHelper::DEFAULT_WIDTH/3, MediaHelper::DEFAULT_HEIGHT/3);
        MediaHelper::ensureDirExists($dst.'70/');
        MediaHelper::resizeImage($src, $dst.'70/'.$id.$ext,
            7*MediaHelper::DEFAULT_WIDTH/10, 7*MediaHelper::DEFAULT_HEIGHT/10);
        MediaHelper::ensureDirExists($dst.'50/');
        MediaHelper::resizeImage($src, $dst.'50/'.$id.$ext,
            5*MediaHelper::DEFAULT_WIDTH/10, MediaHelper::DEFAULT_HEIGHT/2);
        unlink($src);
        return $id.$ext;
    }

    public static function findFile($id){
        $files = scandir(public_path('images/tmp/'));
        foreach($files as $f){
            if(starts_with($f, $id))
                return public_path('images/tmp/').$f;
        }
        return false;
    }

    public static function ensureDirExists($dir){
        if(!file_exists($dir))
            mkdir($dir);
    }

}