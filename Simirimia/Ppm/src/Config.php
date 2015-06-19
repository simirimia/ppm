<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:49
 */

namespace Simirimia\Ppm;

use Simirimia\Core\IniFileConfigDb;

class Config extends IniFileConfigDb implements PpmConfig
{
    /**
     * @var string
     */
    protected $thumbnail_path;

    /**
     * @var string
     */
    protected $picture_source_path;

    /**
     * @return string
     */


    public function getThumbnailPath()
    {
        return $this->thumbnail_path;

    /**
     * @return string
     */  }

    public function getSourcePicturePath()
    {
        return $this->picture_source_path;
   }


}