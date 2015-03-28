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
use Simirimia\Ppm\Command\CreateThumbnails as CreateThumbnailsCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

class CreateThumbnails implements Dispatchable
{
    /**
     * @var CreateThumbnailsCommand
     */
    private $command;

    /**
     * @var PictureRepository
     */
    private $repository;

    public function __construct( CreateThumbnailsCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $picture = $this->repository->findById( $this->command->getId() );

        $thumbnailSizes = [
            'small' => 300,
            'medium' => 800,
            'large' => 1400
        ];

        $imageManager = new ImageManager();

        $orientation = $picture->getExifOrientationObject();

        foreach( $thumbnailSizes as $name => $size )
        {
            $image = $imageManager->make( $picture->getPath() );
            $image->resize($size, $size, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if ( $orientation->getDegreesToRotate() > 0 ) {
                $image->rotate( $orientation->getDegreesToRotate() );
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

        return new ArrayResult( [ 'success' => 'true' ], Result::OK );
    }
}