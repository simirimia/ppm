<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 07.03.15
 * Time: 15:04
 */

namespace Simirimia\Core\ResultRenderer;

use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\FilePathResult;
use Simirimia\Core\Result\CompoundResult;
use Simirimia\Core\Result\Result;
use Simirimia\Core\Response;

class Renderer
{
    public static function render( Result $result, Response $response )
    {
        if ( $result instanceof ArrayResult ) {
            $response->appendToBody( ArrayResultRenderer::render( $result ) );
            $response->setResultCode( $result->getResultCode() );
        } elseif( $result instanceof FilePathResult ) {
            $response->appendToBody( FilePathRenderer::render( $result ) );
            $response->setResultCode( $result->getResultCode() );
        } elseif( $result instanceof CompoundResult ) {
            $results = $result->getResults();
            $total = '[';
            foreach( $results as $current ) {
                ob_start();
                static::render( $current, $response );
                $total .= ob_get_clean() . ', ';
            }
            $total .= ' {} ] ';
            $response->appendToBody( $total );
            $response->setResultCode( $result->getResultCode() );
        } else{
            $errorResult = new ArrayResult([
                'success' => false,
                'message' => 'Unknown result type: ' . get_class( $result )
            ]);
           $errorResult->setResultCode( Result::BACKEND_ERROR );
           $response->appendToBody( ArrayResultRenderer::render( $errorResult ) );
           $response->setResultCode( $result->getResultCode() );
        }
    }
}