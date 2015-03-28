<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 21.02.15
 * Time: 10:41
 */

namespace Simirimia\Ppm\Exif;


class OrientationInfoFactory
{
    private static $classMap = [
        'Canon - Canon PowerShot SX130 IS' => '\Simirimia\Ppm\Exif\Provider\CanonPowerShot',
        'Canon' => '\Simirimia\Ppm\Exif\Provider\Canon'
    ];

    /**
     * @param string $make
     * @param string $model
     * @return OrientationInfoProvider
     */
    public function create( $make, $model )
    {
        $class = null;
        if ( isset( self::$classMap[$make . ' - ' . $model] ) ) {
            $class = self::$classMap[$make . ' - ' . $model];
        } elseif( self::$classMap[$make] ) {
            $class = self::$classMap[$make];
        } else {
            $class = 'OrientationInfoDefault';
        }

        return new $class();
    }
} 