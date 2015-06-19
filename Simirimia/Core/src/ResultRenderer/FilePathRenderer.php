<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            header(  'Content-type: ' . $result->getMimeType() );
            return file_get_contents( $result->getPath() );
            //$handle = fopen( $result->getPath(), 'r' );
            //fpassthru( $handle );
        } else {
            return 'File does not exist: ' . $result->getPath();
        }
    }
}