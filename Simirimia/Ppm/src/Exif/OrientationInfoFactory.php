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
    private $classMap = [
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
        if ( isset( $this->classMap[$make . ' - ' . $model] ) ) {
            $class = $this->classMap[$make . ' - ' . $model];
        } elseif( isset( $this->classMap[$make] )) {
            $class = $this->classMap[$make];
        } else {
            $class = '\Simirimia\Ppm\Exif\Provider\OrientationInfoDefault';
        }

        return new $class();
    }
} 