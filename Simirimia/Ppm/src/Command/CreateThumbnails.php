<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 28.03.15
 * Time: 21:14
 */

namespace Simirimia\Ppm\Command;


class CreateThumbnails
{

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $thumbnailPath;

    public function __construct( $id, $thumbnailPath )
    {
        if ( ! is_int($id) ) {
            throw new \InvalidArgumentException( '$id must be integer' );
        }
        if ( ! is_string($thumbnailPath) ) {
            throw new \InvalidArgumentException( '$thumbnailPath must be string' );
        }
        $this->id = $id;
        $this->thumbnailPath = $thumbnailPath;
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


}