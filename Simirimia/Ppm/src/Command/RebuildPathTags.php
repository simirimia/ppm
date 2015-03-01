<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:32
 */

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\PpmConfig;

class RebuildPathTags {

    /**
     * @var string
     */
    private $basePath;

    public function __construct( PpmConfig $config ) {
        $this->basePath = $config->getSourcePicturePath();
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }


} 