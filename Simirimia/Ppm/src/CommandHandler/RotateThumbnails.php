<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 28.03.15
 * Time: 21:16
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Command\RotateThumbnails as RotateThumbnailsCommand;
use Simirimia\Ppm\Repository\PictureRepository as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

class RotateThumbnails implements Dispatchable
{
    /**
     * @var RotateThumbnailsCommand
     */
    private $command;

    /**
     * @var PictureRepository
     */
    private $repository;

    public function __construct( RotateThumbnailsCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {

        $picture = $this->repository->findById( $this->command->getId() );
        $thumbs = [
            $this->command->getThumbnailPath() . '/' . $picture->getThumbLarge(),
            $this->command->getThumbnailPath() . '/' . $picture->getThumbMedium(),
            $this->command->getThumbnailPath() . '/' . $picture->getThumbSmall()
        ];

        foreach ( $thumbs as $path) {
            if ( !is_writable( $path ) ) {
                throw new \Exception( 'Thumbnail is not writable: ' . $path );
            }
        }

        $imageManager = new ImageManager();

        foreach( $thumbs as $path ) {
            $image = $imageManager->make( $path );
            $image->rotate( $this->command->getDegrees() );
            $image->save( $path );
            $image->destroy();
        }

        return new ArrayResult( [ 'success' => 'true' ], Result::OK );
    }
}