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
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Command\GenerateThumbnails as GenerateThumbnailsCommand;
use Simirimia\Ppm\Entity\Picture;

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

    public function __construct( GenerateThumbnailsCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $pictures = $this->repository->findAll();
        foreach ( $pictures as $picture ) {
            $this->generateThumbnails( $picture );
        }
    }

    private function generateThumbnails( Picture $picture )
    {
        $thumbnailSizes = [
            'small' => 300,
            'medium' => 800,
            'large' => 1400
        ];

        $imageManager = new ImageManager();


        echo "ID: " . $picture->getId() . " Rotation: " . $picture->getExifOrientation() . "\n";


        foreach( $thumbnailSizes as $name => $size )
        {
            $image = $imageManager->make( $picture->getPath() );
            $image->resize($size, $size, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            switch( $picture->getExifOrientation() ) {
                case 6:
                    $image->rotate( 270 );
                    break;
            }

            $path = $this->command->getThumbnailPath() . '/' . $picture->getId() . '_' . (string)$size;

            $image->save( $path );

            switch( $name ) {
                case 'small':
                    $picture->setThumbSmall( $path );
                    break;
                case 'medium':
                    $picture->setThumbMedium( $path );
                    break;
                case 'large':
                    $picture->setThumbLarge( $path );
                    break;
            }
        }

        $this->repository->save( $picture );
    }
} 