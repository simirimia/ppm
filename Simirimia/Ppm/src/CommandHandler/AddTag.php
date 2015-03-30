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
use Simirimia\Ppm\Command\AddTag as AddTagCommand;
use Monolog\Logger;
use Simirimia\Core\Result\ArrayResult;

class AddTag implements Dispatchable
{

    /**
     * @var AddTagCommand
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

    public function __construct(AddTagCommand $command, PictureRepository $repository, Logger $logger)
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $this->logger->addInfo('Updating tags for picture: ' . $this->command->getId());
        /* @var $picture Picture */
        $picture = $this->repository->findById($this->command->getId());
        $picture->addTag($this->command->getTag());
        $this->repository->save($picture);
        return new ArrayResult([
            'status' => 'success',
        ],
            Result::OK);
    }


} 