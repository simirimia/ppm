<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:50
 */

namespace Simirimia\Ppm\ResultRenderer;


use Simirimia\Ppm\Result\PictureCollectionResult;
use Simirimia\Ppm\Entity\Picture;

class PictureCollectionResultRenderer
{
    public static function render( PictureCollectionResult $result )
    {
        $data = [];
        /** @var $picture Picture */
        foreach( $result->getData() as $picture ) {
            $data[] = PictureResultRenderer::extractRenderData( $picture );
        }
        return json_encode( $data );
    }
} 