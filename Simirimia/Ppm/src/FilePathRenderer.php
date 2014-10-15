<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:48
 */

namespace Simirimia\Ppm;


class FilePathRenderer
{
    /**
     * @var FilePathResult
     */
    private $result;

    public function __construct( FilePathResult $result )
    {
        $this->result = $result;
    }

    public function render()
    {
        $path = $this->result->getPath();
        if ( file_exists( $this->result->getPath() ) ) {
            $handle = fopen( $this->result->getPath(), 'r' );
            fpassthru( $handle );
        }
    }
}