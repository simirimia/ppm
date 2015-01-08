<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:48
 */

namespace Simirimia\Ppm\ResultRenderer;


use Simirimia\Ppm\Result\FilePathResult;

class FilePathRenderer
{
    public static function render( FilePathResult $result )
    {
        if ( file_exists( $result->getPath() ) ) {
            header(  'Content-type: ' . $result->getMimeType() );
            $handle = fopen( $result->getPath(), 'r' );
            fpassthru( $handle );
        } else {
            return 'File does not exist: ' . $result->getPath();
        }
    }
}