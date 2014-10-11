<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:31
 */

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\Config;

class GenerateThumbnails {

    /**
     * @var string
     */
    private $thumbnailPath;

    public function __construct( Config $config )
    {
        $this->thumbnailPath = $config->getThumbnailPath();
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }



} 