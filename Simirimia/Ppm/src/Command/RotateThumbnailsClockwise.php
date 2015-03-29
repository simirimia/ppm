<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 29.03.15
 * Time: 13:51
 */

namespace Simirimia\Ppm\Command;


class RotateThumbnailsClockwise extends RotateThumbnails
{
    public function __construct( $id, $thumbnailPath )
    {
        parent::__construct( $id, $thumbnailPath, 90 );
    }
}