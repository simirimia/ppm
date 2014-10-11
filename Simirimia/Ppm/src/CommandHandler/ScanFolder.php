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
        $this->scan( $this->command->getPath() . '/*' );
    }

    private function scan( $dir )
    {
        foreach( glob($dir, GLOB_ONLYDIR ) as $subfolder ) {
            $this->scan( $subfolder . '/*' );
        }
        $this->scanForPicures( $dir );
    }

    private function scanForPicures( $dir )
    {
        $basePath = explode( '/', $this->command->getPath() );
        $dirPath = explode( '/', $dir );
        $pathTags = array_diff( $dirPath, $basePath, ['*'] );

        foreach( glob( $dir . '*.JPG' ) as $path ) {

            if ( null === $this->repository->findByPath($path) ) {
                $picture = new Picture();
                $picture->setPath( $path );
                $picture->addTags( $pathTags );
                $this->repository->save( $picture );
            }
        }

    }

} 