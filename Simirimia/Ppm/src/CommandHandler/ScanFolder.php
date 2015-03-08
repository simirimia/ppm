<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 05.10.14
 * Time: 13:41
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Command\ScanFolder as ScanFolderCommand;
use Monolog\Logger;
use Simirimia\Core\Result\ArrayResult;

class ScanFolder implements Dispatchable {

    /**
     * @var ScanFolderCommand
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

    public function __construct( ScanFolderCommand $command, PictureRepository $repository, Logger $logger )
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $this->scan( $this->command->getPath() . '/*' );

        $result = new ArrayResult( [
            'result' => 'success'
        ] );
        $result->setResultCode( Result::OK );
        return $result;
    }

    private function scan( $dir )
    {
        $this->logger->addDebug( 'Scanning dir: ' . $dir . ' for other dirs' );

        foreach( glob($dir, GLOB_ONLYDIR ) as $subFolder ) {
            $this->scan( $subFolder . '/*' );
        }
        $this->scanForPictures( $dir );
    }

    private function scanForPictures( $dir )
    {
        $this->logger->addDebug( 'Scanning dir: ' . $dir . ' for pictures ' );

        $basePath = explode( '/', $this->command->getPath() );
        $dirPath = explode( '/', $dir );
        $pathTags = array_diff( $dirPath, $basePath, ['*'] );

        foreach( glob( $dir . '*.JPG' ) as $path ) {

            if ( null === $this->repository->findByPath($path) ) {
                $this->logger->addDebug( 'Adding picture: ' . $path );
                $picture = new Picture();
                $picture->setPath( $path );
                $picture->addTags( $pathTags );
                $this->repository->save( $picture );
            } else {
                $this->logger->addDebug( 'Skipping picture: ' . $path );
            }

        }

    }

} 