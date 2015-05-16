<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:08
 */

namespace Simirimia\Ppm\ResultRenderer;

use Simirimia\Ppm\Result\PictureResult;
use Simirimia\Ppm\Entity\Picture;

class PictureResultRenderer
{
    /**
     * @param PictureResult $result
     * @return string
     */
    public static function render( $result )
    {
        if ( !( $result instanceof PictureResult ) ) {
            throw new \InvalidArgumentException( '$result needs to be of type PictureResult' );
        }

        return self::renderPicture( $result->getData() );
    }

    /**
     * @param Picture $picture
     * @return string
     */
    public static function renderPicture( Picture $picture )
    {
        return json_encode( self::extractRenderData( $picture ) );
    }

    /**
     * @param Picture $picture
     * @return array
     */
    public static function extractRenderData( Picture $picture )
    {
        $exif = $picture->getExif();

        $data = [
            'id' => $picture->getId(),
            'hasAlternatives' => $picture->getHasAlternatives(),
            'isAlternativeTo' => ($picture->getIsAlternativeTo() instanceof Picture) ? $picture->getIsAlternativeTo()->getId() : 0,
            'isInGallery' => $picture->isInGallery(),
            'tags' => $picture->getTags(),
            'exif' => []
        ];

        foreach ($exif as $key => $value) {
            $data['exif'][] = ['name' => $key, 'value' => $value];
        }

        return $data;
    }
} 