<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 05.10.14
 * Time: 13:41
 */

namespace Simirimia\Ppm\CommandHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Ppm\Command\RemoveTag as RemoveTagCommand;
use Monolog\Logger;
use Simirimia\Core\Result\ArrayResult;

class RemoveTag implements Dispatchable
{

    /**
     * @var RemoveTagCommand
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

    public function __construct(RemoveTagCommand $command, PictureRepository $repository, Logger $logger)
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $this->logger->addInfo('Removing tag for picture: ' . $this->command->getId());
        /* @var $picture Picture */
        $picture = $this->repository->findById($this->command->getId());
        $picture->removeTag($this->command->getTag());
        $this->repository->save($picture);
        return new ArrayResult([
            'status' => 'success',
            'tags' => $picture->getTags()
        ]);
    }


} 