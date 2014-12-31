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

        // static URLs without variables
        switch( $request->getUrl() )
        {
            case '/rest/pictures/thumbnails/small':
                $query = new Query\AllThumbnails( 'small', $request->getPageSize(), $request->getPageSize()*$request->getPage() );
                return new QueryHandler\AllThumbnails( $query, new PictureRepository() );
        }

        // dynamic URLs
        $matches = [];

        if ( preg_match( '#/rest/pictures/(\d*)/original#', $request->getUrl(), $matches ) ) {
            $query = new Query\Original( $matches[1] );
            return new QueryHandler\Original( $query, new PictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/exif#', $request->getUrl(), $matches ) ) {
            $query = new Query\Exif( $matches[1] );
            return new QueryHandler\Exif( $query, new PictureRepository() );
        }

        if ( preg_match(  '#/rest/tags/(.*)/thumbnails/small#', $request->getUrl(), $matches ) ) {
            $query = new Query\ThumbnailsPerTag( 'small', urldecode($matches[1]), $request->getPageSize(), $request->getPageSize()*$request->getPage() );
            return new QueryHandler\ThumbnailsPerTag( $query, new PictureRepository() );
        }


        return null;
    }
} 