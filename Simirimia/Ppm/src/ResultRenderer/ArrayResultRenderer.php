<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:45
 */

namespace Simirimia\Ppm\ResultRenderer;

use Simirimia\Ppm\Result\ArrayResult;

class ArrayResultRenderer
{
    public static function render( ArrayResult $result )
    {
        return json_encode( $result->getData() );
    }
} 