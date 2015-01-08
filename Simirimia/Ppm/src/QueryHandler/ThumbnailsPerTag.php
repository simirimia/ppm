<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 16.10.14
 * Time: 21:42
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Ppm\Query\ThumbnailsPerTag as ThumbnailPerTagCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Result\ArrayResult;

class ThumbnailsPerTag
{
    /**
     * @var \Simirimia\Ppm\Query\ThumbnailsPerTag
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    public function __construct( ThumbnailPerTagCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $pictures = $this->repository->findByTag( $this->command->getTag(), $this->command->getLimit(), $this->command->getOffset() );
        $data = [];

        /** @var $picture Picture */
        foreach( $pictures as $picture ) {
            switch( $this->command->getType() ) {
                case 'small':
                    $thumbnail = [ 'href' => '/thumbnail/' . $picture->getThumbSmall() ];
                    break;
                case 'medium':
                    $thumbnail = [ 'href' => '/thumbnail/' . $picture->getThumbMedium() ];
                    break;
                case 'large':
                    $thumbnail = [ 'href' => '/thumbnail/' . $picture->getThumbLarge() ];
                    break;
            }
            $thumbnail['tags'] = $picture->getTags();
            $thumbnail['id'] = $picture->getId();

            $data[] = $thumbnail;
        }

        return new ArrayResult( $data );
    }
} 