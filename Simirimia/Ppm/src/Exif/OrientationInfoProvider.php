<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 21.02.15
 * Time: 10:50
 */
namespace Simirimia\Ppm\Exif;

interface OrientationInfoProvider
{
    public function getDegreesToRotate( Orientation $orientation );
}