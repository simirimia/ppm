<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 21:38
 */

namespace Simirimia\Ppm;

use Simirimia\Ppm\Repository\Picture as PictureRepository;

class CommandDispatcher extends Dispatcher
{
    protected  function resolveUrl( $url )
    {

        switch( $url )
        {
            case '/rest/pictures/thumbnails/create':
                $command = new Command\GenerateThumbnails( new Config() );
                $handler = new CommandHandler\GenerateThumbnails( $command, new PictureRepository() );
                return $handler;
            case '/rest/pictures/scan':
                $command = new Command\ScanFolder( new Config() );
                $handler = new CommandHandler\ScanFolder( $command, new PictureRepository(), $this->getLogger() );
                return $handler;
            case '/rest/picture/extract-exif':
                $command = new Command\ExtractExif();
                $handler = new CommandHandler\ExtractExif( $command, new PictureRepository() );
                return $handler;
        }

        return null;
    }
} 