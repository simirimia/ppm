<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 07.03.15
 * Time: 15:06
 */

namespace Simirimia\Ppm\ResultRenderer;

use Simirimia\Core\ResultRenderer\Renderer as CoreResultRenderer;
use Simirimia\Core\ResultRenderer\ResultRenderer;
use Simirimia\Ppm\Result\PictureResult;
use Simirimia\Ppm\Result\PictureCollectionResult;
use Simirimia\Core\Result\Result;
use Simirimia\Core\Response;

class Renderer extends CoreResultRenderer
{
    public static function render( Result $result, Response $response )
    {
        if( $result instanceof PictureResult ) {
            $response->appendToBody( PictureResultRenderer::render( $result ) );
            $response->setResultCode( $result->getResultCode() );
        } elseif( $result instanceof PictureCollectionResult ) {
            $response->appendToBody( PictureCollectionResultRenderer::render( $result ) );
            $response->setResultCode( $result->getResultCode() );
        } else {
            parent::render( $result, $response );
        }
    }
}