<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 15.10.14
 * Time: 23:34
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Ppm\Query\PictureDetails as PictureDetailsCommand;
use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\ArrayResult;

class PictureDetails
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
     * @return ArrayResult
     */
    public function process()
    {
        $picture = $this->repository->findById($this->command->getId());

        $exif = $picture->getExif();

        $data = [
            'tags' => $picture->getTags(),
            'exif' => []
        ];

        foreach ($exif as $key => $value) {
            $data['exif'][] = ['name' => $key, 'value' => $value];
        }


        return new ArrayResult($data);
    }
} 