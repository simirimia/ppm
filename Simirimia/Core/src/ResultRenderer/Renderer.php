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

use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\CompoundResult;
use Simirimia\Core\Result\FilePathResult;
use Simirimia\Core\Result\Result;

class Renderer
{
    /**
     * @param Result $result
     * @return string
     * @throws \Exception
     */
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
