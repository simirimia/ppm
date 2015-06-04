<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:34
 */

namespace Simirimia\Ppm\QueryHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Query\Exif as ExifCommand;
use Simirimia\Ppm\Repository\PictureRepository as PictureRepository;
use Simirimia\Core\Result\ArrayResult;

class Exif implements Dispatchable
{

    /**
     * @var \Simirimia\Ppm\Query\Original
     */
    private $command;

    /**
     * @var \Simirimia\Ppm\Repository\PictureRepository
     */
    private $repository;

    /**
     * @param ExifCommand $command
     * @param PictureRepository $repository
     */
    public function __construct( ExifCommand $command, PictureRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    /**
     * @return ArrayResult
     */
    public function process()
    {
        $picture = $this->repository->findById( $this->command->getId() );

        $exif = $picture->getExif();

        $data = [];

        foreach( $exif as $key => $value ) {
            $data[] = [ 'name' => $key, 'value' => $value ];
        }

        $result = new ArrayResult( $data );
        $result->setResultCode( Result::OK );
        return $result;
    }
} 