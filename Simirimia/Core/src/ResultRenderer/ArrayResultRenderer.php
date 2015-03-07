<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:45
 */

namespace Simirimia\Core\ResultRenderer;

use Simirimia\Core\Result\ArrayResult;

class ArrayResultRenderer implements ResultRenderer
{
    public static function render( $result )
    {
        if ( !( $result instanceof ArrayResult ) ) {
            throw new \InvalidArgumentException( '$result needs to be of type ArrayResult' );
        }

        return json_encode( $result->getData() );
    }
} 