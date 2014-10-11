<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:49
 */

namespace Simirimia\Ppm;


class Config
{

    public function getThumbnailPath()
    {
        return '/srv/www/ppm/thumbnails';
    }

    public function getSourcePicturePath()
    {
        return '/home/verena/Bilder/*.JPG';
    }

} 