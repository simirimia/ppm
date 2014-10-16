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
        if ( file_exists( $this->result->getPath() ) ) {
            header(  'Content-type: ' . $this->result->getMimeType() );
            $handle = fopen( $this->result->getPath(), 'r' );
            fpassthru( $handle );
        } else {
            var_dump( $this->result->getPath() );
        }
    }
}