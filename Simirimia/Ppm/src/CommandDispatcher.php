<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 11.10.14
 * Time: 21:38
 */

namespace Simirimia\Ppm;

use Simirimia\Core\DispatchableChain;
use Simirimia\Core\Dispatcher;
use Simirimia\Core\Request;
use Simirimia\Ppm\CommandHandler\RotateThumbnails;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\User\CommandDispatcher as UserCommandDispatcher;


class CommandDispatcher extends Dispatcher
{
    protected function resolveUrl( Request $request )
    {

        switch ( $request->getUrl() ) {
            case '/rest/pictures/thumbnails/create':
                if ( $request->getMethod() == Request::POST ) {
                    $command = new Command\GenerateThumbnails( $this->getConfig()->getThumbnailPath() );
                    $handler = new CommandHandler\GenerateThumbnails(
                        $command,
                        new PictureRepository(),
                        $this->getLogger()
                    );

                    return $handler;
                }
                break;
            case '/rest/pictures/scan':
                if ( $request->getMethod() == Request::POST ) {
                    $path = $request->getBody();
                    if ( empty( $path ) ) {
                        $path = $this->getConfig()->getSourcePicturePath();
                    }
                    $command = new Command\ScanFolder( $path );
                    $handler = new CommandHandler\ScanFolder( $command, new PictureRepository(), $this->getLogger() );

                    return $handler;
                }
                break;
            case '/rest/pictures/rebuild-path-tags':
                if ( $request->getMethod() == Request::POST ) {
                    $path = $request->getBody();
                    if ( empty( $path ) ) {
                        $path = $this->getConfig()->getSourcePicturePath();
                    }
                    $command = new Command\RebuildPathTags( $path );
                    $handler = new CommandHandler\RebuildPathTags(
                        $command, new PictureRepository(), $this->getLogger()
                    );

                    return $handler;
                }
                break;
            case '/rest/pictures/extract-exif':
                if ( $request->getMethod() == Request::POST ) {
                    $command = new Command\ExtractExif();
                    $handler = new CommandHandler\ExtractExif( $command, new PictureRepository(), $this->getLogger() );

                    return $handler;
                }
                break;
        }

        // URLs including some parameters

        if ( preg_match( '#/rest/pictures/(\d*)/alternatives$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::POST ) {
                $command = new Command\AddAlternative( (int)$matches[1], (int)$request->getBody() );
                $handler = new CommandHandler\AddAlternative( $command, new PictureRepository(), $this->getLogger() );

                return $handler;
            }
        }

        if ( preg_match( '#/rest/pictures/(\d*)/tags$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::POST ) {
                $chain = new DispatchableChain();

                $command = new Command\AddTag( (int)$matches[1], (string)$request->getBody() );
                $handler = new CommandHandler\AddTag( $command, new PictureRepository(), $this->getLogger() );
                $chain->add( $handler );

                $command = new Command\UpdateTagCount( (string)$request->getBody() );
                $handler = new CommandHandler\UpdateTagCount( $command, new DatabaseCommand\Tag() );
                $chain->add( $handler );

                return $chain;
            }
        }

        if ( preg_match( '#/rest/pictures/(\d*)/tags/(.*)#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::DELETE ) {
                $command = new Command\RemoveTag( (int)$matches[1], (string)$matches[2] );
                $handler = new CommandHandler\RemoveTag( $command, new PictureRepository(), $this->getLogger() );

                return $handler;
            }
        }

        if ( preg_match( '#/rest/pictures/(\d*)/thumbnails$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::DELETE ) {
                $command = new Command\DeleteThumbnails( (int)$matches[1], $this->getConfig()->getThumbnailPath() );
                $handler = new CommandHandler\DeleteThumbnails( $command, new PictureRepository() );

                return $handler;
            }
            if ( $request->getMethod() == Request::POST ) {
                $command = new Command\CreateThumbnails( (int)$matches[1], $this->getConfig()->getThumbnailPath() );
                $handler = new CommandHandler\CreateThumbnails( $command, new PictureRepository() );

                return $handler;
            }
        }

        if ( preg_match( '#/rest/pictures/(\d*)/thumbnails/rotate$#', $request->getUrl(), $matches ) ) {
            if ( $request->getMethod() == Request::POST ) {
                $rotateType = $request->getBody();
                if ( $rotateType == 'clockwise' ) {
                    $command = new Command\RotateThumbnailsClockwise(
                        (int)$matches[1],
                        $this->getConfig()->getThumbnailPath()
                    );
                } elseif ( $rotateType == 'counterclockwise' ) {
                    $command = new Command\RotateThumbnailsCounterClockwise(
                        (int)$matches[1],
                        $this->getConfig()->getThumbnailPath()
                    );
                } elseif ( (int)$rotateType > 0 && (int)$rotateType < 360 ) {
                    $command = new Command\RotateThumbnails(
                        (int)$matches[1],
                        $this->getConfig()->getThumbnailPath(),
                        (int)$rotateType
                    );
                } else {
                    throw new \InvalidArgumentException(
                        'body must contain clockwise, counterclockwise or an integer 0 < $int < 360'
                    );
                }

                return new RotateThumbnails( $command, new PictureRepository() );
            }
        }

        $userDispatcher = new UserCommandDispatcher( $this->getLogger(), $this->getConfig() );

        return $userDispatcher->resolveUrl( $request );
    }

    /**
     * @return PpmConfig
     */
    protected function getConfig()
    {
        return parent::getConfig();
    }
} 