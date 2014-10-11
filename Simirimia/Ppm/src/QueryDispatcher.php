<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 21:38
 */

namespace Simirimia\Ppm;

use Simirimia\Ppm\Repository\Picture as PictureRepository;

class QueryDispatcher extends Dispatcher
{
    protected function resolveUrl( $url )
    {

        switch( $url )
        {
            case '/rest/pictures/thumbnails/small':
                $query = new Query\AllThumbnails( 'small' );
                $handler = new QueryHandler\AllThumbnails( $query, new PictureRepository() );
                return $handler;
        }


        return null;
    }
} 