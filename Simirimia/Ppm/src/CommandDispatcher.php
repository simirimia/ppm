<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 21:38
 */

namespace Simirimia\Ppm;

use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Repository\Picture;

class CommandDispatcher extends Dispatcher
{
    protected  function resolveUrl( Request $request )
    {

        switch( $request->getUrl() )
        {
            case '/rest/pictures/thumbnails/create':
                $command = new Command\GenerateThumbnails( new Config() );
                $handler = new CommandHandler\GenerateThumbnails( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            case '/rest/pictures/scan':
                $command = new Command\ScanFolder( new Config() );
                $handler = new CommandHandler\ScanFolder( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            case '/rest/pictures/extract-exif':
                $command = new Command\ExtractExif();
                $handler = new CommandHandler\ExtractExif( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            case '/rest/pictures/rebuild-path-tags':
                $command = new Command\RebuildPathTags( new Config );
                $handler = new CommandHandler\RebuildPathTags( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
        }

        // URLs including some parameters

        if ( preg_match( '#/rest/pictures/(\d*)/tags$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::POST ) {
                $command = new Command\AddTag( (int)$matches[1], (string)$request->getBody() );
                $handler = new CommandHandler\AddTag( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            }
        }

        if ( preg_match( '#/rest/pictures/(\d*)/alternatives$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::POST ) {
                $command = new Command\AddAlternative( (int)$matches[1], (int)$request->getBody() );
                $handler = new CommandHandler\AddAlternative( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            }
        }


        if ( preg_match( '#/rest/pictures/(\d*)/tags/(.*)#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::DELETE ) {
                $command = new Command\RemoveTag( (int)$matches[1], (string)$matches[2] );
                $handler = new CommandHandler\RemoveTag( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            }
        }

        return null;
    }
} 