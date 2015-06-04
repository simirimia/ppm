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
use Simirimia\Ppm\Command\DeleteThumbnails as DeleteThumbnailsCommand;
use Simirimia\Ppm\Repository\PictureRepository as PictureRepository;
use Simirimia\Ppm\Entity\Picture;

class DeleteThumbnails implements Dispatchable
{
    /**
     * @var DeleteThumbnailsCommand
     */
    private $command;

    /**
     * @var PictureRepository
     */
    private $repository;

    public function __construct( DeleteThumbnailsCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $picture = $this->repository->findById( $this->command->getId() );
        $path = $this->command->getThumbnailPath() . '/' . $picture->getThumbLarge();
        if ( !is_writable( $path ) ) {
            throw new \Exception( 'large thumb is not writable: ' . $path );
        }
        if ( $picture->getThumbLarge() != null ) {
            unlink( $path );
            $picture->setThumbLarge( null );
        }

        $path = $this->command->getThumbnailPath() . '/' . $picture->getThumbMedium();
        if ( !is_writable( $path ) ) {
            throw new \Exception( 'medium thumb is not writable: ' . $path );
        }
        if ( $picture->getThumbMedium() != null ) {
            unlink( $path );
            $picture->setThumbMedium( null );
        }

        $path = $this->command->getThumbnailPath() . '/' . $picture->getThumbSmall();
        if ( !is_writable( $path ) ) {
            throw new \Exception( 'small thumb is not writable: ' . $path );
        }
        if ( $picture->getThumbSmall() != null ) {
            unlink( $path );
            $picture->setThumbSmall( null );
        }

        $this->repository->save( $picture );

        return new ArrayResult( [ 'success' => 'true' ], Result::OK );
    }
}