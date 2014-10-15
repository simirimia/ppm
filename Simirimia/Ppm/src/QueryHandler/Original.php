<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:34
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Ppm\FilePathResult;
use Simirimia\Ppm\Query\Original as OriginalCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;

class Original
{

    /**
     * @var \Simirimia\Ppm\Query\Original
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    /**
     * @param OriginalCommand $command
     * @param PictureRepository $repository
     */
    public function __construct( OriginalCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    /**
     * @return FilePathResult
     */
    public function process()
    {
        $picture = $this->repository->findById( $this->command->getId() );
        return new FilePathResult( $picture->getPath() );
    }
} 