<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:32
 */

namespace Simirimia\Ppm\Command;

class RebuildPathTags {

    /**
     * @var string
     */
    private $basePath;

    public function __construct( $pictureSourcePath ) {
        if ( !is_string($pictureSourcePath) ) {
            throw new \InvalidArgumentException( '$pictureSourcePath needs to be string' );
        }
        $this->basePath = $pictureSourcePath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }


} 