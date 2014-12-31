<?php

namespace Terart\Delegations\DelegationsBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class GraphicsController
{
    const LOGO_WIDTH = 120;
    const LOGO_HEGIHT = 30;

    public function resizeLogo($file)
    {
//        var_dump($file);
//        die;

        list($srcImgWidth, $srcImgHeight, $srcImgType) = getimagesize($file);

        switch ($srcImgType) {
            case IMAGETYPE_GIF:
                $srcImage = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG:
                $srcImage = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG:
                $srcImage = imagecreatefrompng($file);
                break;
        }

        if ($srcImage === false) {
            return false;
        }

        $ratio = $srcImgWidth / $srcImgHeight;
        $logoRatio = self::LOGO_WIDTH / self::LOGO_HEGIHT;

        if ($srcImgWidth <= self::LOGO_WIDTH && $srcImgHeight <= self::LOGO_HEGIHT) {
            $LOGO_WIDTH = $srcImgWidth;
            $LOGO_HEGIHT = $srcImgHeight;
        }else{
            $scale = min(self::LOGO_WIDTH/$srcImgWidth, self::LOGO_HEGIHT/$srcImgHeight);
            $LOGO_WIDTH  = ceil($scale*$srcImgWidth);
            $LOGO_HEGIHT = ceil($scale*$srcImgHeight);
        }

        $logImage = imagecreatetruecolor($LOGO_WIDTH, $LOGO_HEGIHT);
//        imagecopyresampled($logImage, $srcImage, 0, 0, 0, 0, $LOGO_WIDTH, $LOGO_HEGIHT, $srcImgWidth, $srcImgHeight);
        imagecopyresampled($logImage, $srcImage, 0, 0, 0, 0, $LOGO_WIDTH, $LOGO_HEGIHT, $srcImgWidth, $srcImgHeight);
        imagejpeg($logImage, $file, 90);
        imagedestroy($srcImage);
        imagedestroy($logImage);
        return $file;
    }
} 