<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 15.10.14
 * Time: 23:34
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Ppm\Query\PictureDetails as PictureDetailsCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Result\PictureResult;

class PictureDetails implements Dispatchable
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
     * @param PictureDetailsCommand $command
     * @param PictureRepository $repository
     */
    public function __construct(PictureDetailsCommand $command, PictureRepository $repository)
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    /**
     * @return PictureResult
     */
    public function process()
    {
        $picture = $this->repository->findById($this->command->getId());
        return new PictureResult( $picture );
    }
} 