<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:45
 */

namespace Simirimia\Core\ResultRenderer;

use Simirimia\Core\Result\ArrayResult;

class ArrayResultRenderer
{
    public static function render( ArrayResult $result )
    {
        return json_encode( $result->getData() );
    }
} 