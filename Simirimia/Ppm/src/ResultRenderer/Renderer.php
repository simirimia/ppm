<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 07.03.15
 * Time: 15:06
 */

namespace Simirimia\Ppm\ResultRenderer;

use Simirimia\Core\ResultRenderer\Renderer as CoreResultRenderer;
use Simirimia\Core\ResultRenderer\ResultRenderer\ResultRenderer;
use Simirimia\Ppm\Result\PictureResult;
use Simirimia\Ppm\Result\PictureCollectionResult;

class Renderer extends CoreResultRenderer
{
    public static function render( ResultRenderer $result )
    {
        if( $result instanceof PictureResult ) {
            return PictureResultRenderer::render( $result );
        }
        if( $result instanceof PictureCollectionResult ) {
            return PictureCollectionResultRenderer::render( $result );
        }
        return parent::render( $result );
    }
}