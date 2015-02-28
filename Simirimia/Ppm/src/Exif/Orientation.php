<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 14.02.15
 * Time: 10:46
 */

namespace Simirimia\Ppm\Exif;


class Orientation
{
    /**
     * @var int
     */
    private $orientation;

    /**
     * @var string
     */
    private $make;

    /**
     * @var string
     */
    private $model;

    public static function fromExifArray( array $exif )
    {
        $make = '';
        $model = '';

        if ( isset($exif['Orientation']) ) {
            $orientation = (int)$exif['Orientation'];
        } else {
            throw new \InvalidArgumentException( 'Orientation key in array is mandatory' );
        }

        if ( isset($exif['Make']) ) {
            $make = (string)$exif['Make'];
        }
        if ( isset($exif['Model']) ) {
            $model = (string)$exif['Model'];
        }

        return new Orientation( $orientation, $make, $model );
    }

    public function __construct( $orientation, $make, $model )
    {
        $this->orientation = (int)$orientation;
        $this->make = (string)$make;
        $this->model = (string)$model;
    }

    public function getDegreeesToRotate()
    {
        // go one here
        // OrientationFactory needed --> then get degrees !
        return 999;
    }

    /**
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return int
     */
    public function getOrientation()
    {
        return $this->orientation;
    }


} 