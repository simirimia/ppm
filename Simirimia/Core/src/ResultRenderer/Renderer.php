<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 07.03.15
 * Time: 15:04
 */

namespace Simirimia\Core\ResultRenderer;

use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\CompoundResult;
use Simirimia\Core\Result\FilePathResult;
use Simirimia\Core\Result\Result;

class Renderer
{
    public static function render( Result $result )
    {
        if ( $result instanceof ArrayResult ) {
            return ArrayResultRenderer::render( $result );
        } elseif ( $result instanceof FilePathResult ) {
            return FilePathRenderer::render( $result );
        } elseif ( $result instanceof CompoundResult ) {
            $results = $result->getResults();
            $total = '[';
            foreach ( $results as $current ) {
                $total .= static::render( $current ) . ', ';
            }
            $total .= ' {} ] ';
            return $total;
        } else {
            throw new \Exception( 'Unknown result type: ' . get_class( $result ) );
        }
    }
}
