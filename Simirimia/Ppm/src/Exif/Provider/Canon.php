<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 21.02.15
 * Time: 10:58
 */

namespace Simirimia\Ppm\Exif\Provider;

use Simirimia\Ppm\Exif\OrientationInfoProvider;

use Simirimia\Ppm\Exif\Orientation;

class Canon implements OrientationInfoProvider
{
    public function getDegreesToRotate( Orientation $orientation )
    {
        switch( $orientation->getOrientation() ) {
            case 0:
                break;
            case 1:
                break;
            case 6:
                return 270;
                break;
            case 8:
                break;

        }

        return 0;
    }

} 