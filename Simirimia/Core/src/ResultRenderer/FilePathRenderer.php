<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:48
 */

namespace Simirimia\Core\ResultRenderer;


use Simirimia\Core\Result\FilePathResult;

class FilePathRenderer implements ResultRenderer
{
    /**
     * @param FilePathResult $result
     * @return string
     */
    public static function render( $result )
    {
        if ( !( $result instanceof FilePathResult ) ) {
            throw new \InvalidArgumentException( '$result needs to be of type FilePathResult' );
        }

        if ( file_exists( $result->getPath() ) ) {
            // todo: renderer needs possibility to define mime type
            header(  'Content-type: ' . $result->getMimeType() );
            return file_get_contents( $result->getPath() );
            //$handle = fopen( $result->getPath(), 'r' );
            //fpassthru( $handle );
        } else {
            return 'File does not exist: ' . $result->getPath();
        }
    }
}