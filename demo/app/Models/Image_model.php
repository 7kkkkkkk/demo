<?php namespace App\Models;

use CodeIgniter\Model;

class Image_model extends Model {

    protected $allowedFields = ['filename', 'path'];

    // Crop image
    public function crop($path, $filename) {
        echo $path, $filename;
        $imagick = new \Imagick($path.$filename);
        $width = $imagick->getImageWidth();
        $height = $imagick->getImageHeight();
        $imagick->cropImage($width/2, $height/2, $width/4, $height/4);
        $imagick->writeImage($path.'crop_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'crop_'.$filename;
    }

    public function rotate($path,$filename, $degrees=180) {
        $imagick = new \Imagick($path.$filename);
        $imagick->rotateImage(new \ImagickPixel(), $degrees);
        $imagick->writeImage($path.'rot_'.$filename);
        $imagick->clear();
        $imagick->destroy();
        return 'rot_'.$filename;
    }
}
