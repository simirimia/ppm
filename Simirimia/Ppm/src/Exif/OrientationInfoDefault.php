<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 21.02.15
 * Time: 10:42
 */

namespace Simirimia\Ppm\Exif;


class OrientationInfoDefault implements OrientationInfoProvider
{
    public function getDegreesToRotate( $orientation )
    {
        if ( !is_int($orientation) ) {
            throw new \InvalidArgumentException( 'Orientation must be integer' );
        }

        return 999;
    }
} 