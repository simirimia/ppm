<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:31
 */

namespace Simirimia\Ppm\Command;

class GenerateThumbnails {

    /**
     * @var string
     */
    private $thumbnailPath;

    public function __construct( $thumbnailPath )
    {
        if ( !is_string($thumbnailPath) ) {
            throw new \InvalidArgumentException( '$thumbnailPath needs to be string' );
        }
        $this->thumbnailPath = $thumbnailPath;
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }



} 