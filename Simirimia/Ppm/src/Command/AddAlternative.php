<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:31
 */

namespace Simirimia\Ppm\Command;


class AddAlternative {

    /***
     * @var int
     */
    private $mainPictureId;

    /**
     * @var int
     */
    private $alternativePictureId;

    public function __construct( $mainPictureId, $alternativePictureId )
    {
        if( !is_int($mainPictureId) ) {
            throw new \Exception( 'mainPictureId must be an integer' );
        }
        if ( !is_int($alternativePictureId) ) {
            throw new \Exception( 'alternativePictureId must be an integer' );
        }
        $this->mainPictureId = $mainPictureId;
        $this->alternativePictureId = $alternativePictureId;
    }

    /**
     * @return int
     */
    public function getAlternativePictureId()
    {
        return $this->alternativePictureId;
    }

    /**
     * @return int
     */
    public function getMainPictureId()
    {
        return $this->mainPictureId;
    }



}