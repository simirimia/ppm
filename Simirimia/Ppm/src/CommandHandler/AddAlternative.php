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
use Simirimia\Ppm\Command\AddAlternative as AddAlternativeCommand;
use Monolog\Logger;
use Simirimia\Ppm\ArrayResult;

class AddAlternative
{

    /**
     * @var AddAlternativeCommand
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

    public function __construct(AddAlternativeCommand $command, PictureRepository $repository, Logger $logger)
    {
        $this->command = $command;
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function process()
    {
        $this->logger->addInfo( 'Adding an alternative. Main Picure is: ' . $this->command->getMainPictureId() . ' and the new alternative is: ' . $this->command->getAlternativePictureId() );

        $mainPicture = $this->repository->findById($this->command->getMainPictureId());
        $alternativePicture = $this->repository->findById( $this->command->getAlternativePictureId() );
        $alternativePicture->setIsAlternativeTo( $mainPicture );

        $this->repository->save($alternativePicture);

        return new ArrayResult([
            'status' => 'success'
        ]);
    }


} 