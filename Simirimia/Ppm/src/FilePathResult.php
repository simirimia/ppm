<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:44
 */

namespace Simirimia\Ppm;


class FilePathResult {

    /**
     * @var string
     */
    private $path;

    public function __construct( $path )
    {
        $this->path = (string)$path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


}