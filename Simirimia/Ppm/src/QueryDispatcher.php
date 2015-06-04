<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 21:38
 */

namespace Simirimia\Ppm;

use Simirimia\Ppm\Repository\Tag as TagRepository;
use Simirimia\Core\Request;
use Simirimia\Core\Dispatcher;

class QueryDispatcher extends Dispatcher
{
    protected function resolveUrl( Request $request )
    {

        // static URLs without variables
        switch( $request->getUrl() )
        {
            case '/rest/pictures/thumbnails/small':
                $query = new Query\AllThumbnails( 'small', $request->getPageSize(), $request->getPageSize()*($request->getPage()-1) );
                return new QueryHandler\AllThumbnails( $query, $this->getPictureRepository() );
            case '/rest/tags':
                $query = new Query\Tags();
                return new QueryHandler\Tags( $query, new TagRepository() );
        }

        // dynamic URLs
        $matches = [];

        // URLs starting with /rest/pictures
        if ( preg_match( '#/rest/pictures/(\d*)/alternatives#', $request->getUrl(), $matches ) ) {
            $query = new Query\Alternatives( (int)$matches[1] );
            return new QueryHandler\Alternatives( $query, $this->getPictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/details#', $request->getUrl(), $matches ) ) {
            $query = new Query\PictureDetails( (int)$matches[1] );
            return new QueryHandler\PictureDetails( $query, $this->getPictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/exif#', $request->getUrl(), $matches ) ) {
            $query = new Query\Exif( (int)$matches[1] );
            return new QueryHandler\Exif( $query, $this->getPictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/tags#', $request->getUrl(), $matches ) ) {
            $query = new Query\TagsForPicture( (int)$matches[1] );
            return new QueryHandler\TagsForPicture( $query, $this->getPictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/original#', $request->getUrl(), $matches ) ) {
            $query = new Query\Original( (int)$matches[1] );
            return new QueryHandler\Original( $query, $this->getPictureRepository() );
        }

        if ( preg_match( '#/rest/pictures/(\d*)/orientation#', $request->getUrl(), $matches ) ) {
            $query = new Query\OrientationInfo( (int)$matches[1] );
            return new QueryHandler\OrientationInfo( $query, $this->getPictureRepository() );
        }


        // URLs starting with /rest/tags

        if ( preg_match(  '#/rest/tags/(.*)/thumbnails/small#', $request->getUrl(), $matches ) ) {
            $query = new Query\ThumbnailsPerTag( 'small', urldecode($matches[1]), $request->getPageSize(), $request->getPageSize()*($request->getPage()-1) );
            return new QueryHandler\ThumbnailsPerTag( $query, $this->getPictureRepository() );
        }


        return null;
    }

    /**
     * @return PpmConfigUser
     */
    protected function getConfig()
    {
        return parent::getConfig();
    }
} 