<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 21.02.15
 * Time: 10:58
 */

namespace Simirimia\Ppm\Exif\Provider;

use Simirimia\Ppm\Exif\OrientationInfoProvider;

class CanonPowerShot implements OrientationInfoProvider
{
    public function getDegreesToRotate($orientation)
    {

        switch( $orientation ) {
            case 0:
                break;
            case 1:
                break;
            case 6:
                return 270;
                break;
            case 8:
                break;
            default:
                return -1;

        }

    }
} 