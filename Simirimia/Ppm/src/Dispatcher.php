<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:56
 */

namespace Simirimia\Ppm;

abstract class Dispatcher
{

    public function dispatch( $url )
    {
        $handler = $this->resolveUrl( $url );

        if ( $handler === null ) {
            return [ 'error' => 'No handler found' ];
        }

        return $handler->process();
    }

    protected abstract function resolveUrl( $url );

} 