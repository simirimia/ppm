<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:36
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Ppm\ArrayResult;
use Simirimia\Ppm\Query\AllThumbnails as AllThumbnailsCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;

class AllThumbnails
{
    /**
     * @var \Simirimia\Ppm\Query\AllThumbnails
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    public function __construct( AllThumbnailsCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $pictures = $this->repository->findLimitedSet( $this->command->getLimit(), $this->command->getOffset() );
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