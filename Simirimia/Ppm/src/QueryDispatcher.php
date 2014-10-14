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
    protected function resolveUrl( Request $request )
    {

        switch( $request->getUrl() )
        {
            case '/rest/pictures/thumbnails/small':
                $query = new Query\AllThumbnails( 'small', $request->getPageSize(), $request->getPageSize()*$request->getPage() );
                $handler = new QueryHandler\AllThumbnails( $query, new PictureRepository() );
                return $handler;
        }


        return null;
    }
} 