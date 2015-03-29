<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 28.03.15
 * Time: 21:14
 */

namespace Simirimia\Ppm\Command;


class RotateThumbnails
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $degrees;
    /**
     * @var string
     */
    private $thumbnailPath;

    public function __construct( $id, $thumbnailPath, $degrees )
    {
        if ( ! is_int($id) ) {
            throw new \InvalidArgumentException( '$id must be integer' );
        }
        if ( ! is_string($thumbnailPath) ) {
            throw new \InvalidArgumentException( '$thumbnailPath must be string' );
        }
        if ( !is_int($degrees) ) {
            throw new \InvalidArgumentException( 'degrees must be integer' );
        }
        $this->id = $id;
        $this->thumbnailPath = $thumbnailPath;
        $this->degrees = $degrees;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }

    /**
     * @return int
     */
    public function getDegrees()
    {
        return $this->degrees;
    }



}