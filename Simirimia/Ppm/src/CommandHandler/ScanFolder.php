<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 05.10.14
 * Time: 13:41
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Command\ScanFolder as ScanFolderCommand;

class ScanFolder {

    /**
     * @var ScanFolderCommand
     */
    private $command;

    /**
     * @var PictureRepository
     */
    private $repository;

    public function __construct( ScanFolderCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        foreach( glob($this->command->getPath() ) as $path ) {

            if ( null === $this->repository->findByPath($path) ) {
                $picture = new Picture();
                $picture->setPath( $path );
                $this->repository->save( $picture );
            }
        }
    }

} 