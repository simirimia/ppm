<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:34
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Ppm\Result\PictureCollectionResult;
use Simirimia\Ppm\Query\Alternatives as AlternativesCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;

class Alternatives
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
     * @param AlternativesCommand $command
     * @param PictureRepository $repository
     */
    public function __construct( AlternativesCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    /**
     * @return PictureCollectionResult
     */
    public function process()
    {
        $picture = $this->repository->findById( $this->command->getId() );

        return new PictureCollectionResult( $picture->getAlternatives() );
    }
} 