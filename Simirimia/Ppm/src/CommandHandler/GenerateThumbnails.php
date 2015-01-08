<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 17:23
 */

namespace Simirimia\Ppm\CommandHandler;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Simirimia\Ppm\ArrayResult;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Command\GenerateThumbnails as GenerateThumbnailsCommand;
use Simirimia\Ppm\Entity\Picture;
use Monolog\Logger;

class GenerateThumbnails
{

    /**
     * @var PictureRepository
     */
    private $repository;

    /**
     * @var GenerateThumbnailsCommand
     */
    private $command;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    public function __construct( GenerateThumbnailsCommand $command, PictureRepository $repository, Logger $logger )
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $pictures = $this->repository->findWithoutThumbnails( 2000 );
        $i=0;
        foreach ( $pictures as $picture ) {
            $i++;
            $this->generateThumbnails( $picture );
            if ( $i > 1000 ) {
                return new ArrayResult( [ 'success' => 'intermediate' ] );
            }
        }
        return new ArrayResult( [ 'success' => true ] );
    }

    private function generateThumbnails( Picture $picture )
    {
        if ( $picture->getThumbSmall() != '' ) {
            $this->logger->addDebug( 'Thumbnail creation canceled for picture ID: ' . $picture->getId() . ' -- already exists' );
            return;
        }

        if ( $picture->getExifOrientation() == '' ) {
            $this->logger->addDebug( 'Thumbnail creation canceled for picture ID: ' . $picture->getId() . ' -- no EXIF information' );
            return;
        }



        $this->logger->addDebug( 'Thumbnail creation for picture ID: ' . $picture->getId() . ' with name ' . $picture->getPath() );

        $thumbnailSizes = [
            'small' => 300,
            'medium' => 800,
            'large' => 1400
        ];

        $imageManager = new ImageManager();


        $this->logger->addDebug( "ID: " . $picture->getId() . " Rotation: " . $picture->getExifOrientation() . "\n" );


        foreach( $thumbnailSizes as $name => $size )
        {
            $image = $imageManager->make( $picture->getPath() );
            $image->resize($size, $size, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            switch( $picture->getExifOrientation() ) {
                case 0:
                    break;
                case 1:
                    break;
                case 6:
                    $image->rotate( 270 );
                    break;
                case 8:
                    break;
                default:
                    $this->logger->addError( 'Invalid Orientation: ' . $picture->getExifOrientation() . ' for picture ID: ' . $picture->getId() . ' with name: ' . $picture->getPath() );
                    return;
                    //throw new \Exception( 'Invalid Orientation: ' . $picture->getExifOrientation() . ' for picture ID: ' . $picture->getId() . ' with name: ' . $picture->getPath() );

            }

            $filename = $picture->getId() . '_' . (string)$size . '.jpg';

            $path = $this->command->getThumbnailPath() . '/' . $filename;

            $image->save( $path );

            switch( $name ) {
                case 'small':
                    $picture->setThumbSmall( $filename );
                    break;
                case 'medium':
                    $picture->setThumbMedium( $filename );
                    break;
                case 'large':
                    $picture->setThumbLarge( $filename );
                    break;
            }
        }

        $this->repository->save( $picture );
    }
} 