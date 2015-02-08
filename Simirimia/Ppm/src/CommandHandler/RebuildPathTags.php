<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 05.10.14
 * Time: 13:41
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Ppm\Dispatchable;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Command\RebuildPathTags as RebuildPathTagsCommand;
use Monolog\Logger;
use Simirimia\Ppm\Result\ArrayResult;

class RebuildPathTags implements Dispatchable
{

    /**
     * @var RebuildPathTagsCommand
     */
    private $command;

    /**
     * @var PictureRepository
     */
    private $repository;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    public function __construct(RebuildPathTagsCommand $command, PictureRepository $repository, Logger $logger)
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $basePath = explode( '/', $this->command->getBasePath() );

        $pics = $this->repository->findAll();

        $i=0;

        /* @var $picture Picture */
        foreach( $pics as $picture ) {
            $i++;
            $this->logger->addInfo('Rebuilding path tags for picture: ' . $picture->getId());
            $path = explode( '/', $picture->getPath() );
            array_pop( $path );
            $picture->addTags( array_diff( $path, $basePath ) );
            $this->repository->save( $picture );
            //if ( $i>1000 ) return;
        }

        return new ArrayResult( [ 'success' => true ] );
    }


} 