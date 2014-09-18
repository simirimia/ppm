<?php

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;

class ScanFolder {

    /**
     * @var string
     */
    private $path;

    /**
     * @var PictureRepository
     */
    private $repository;

    public function __construct( $path, PictureRepository $repository )
    {
        $this->path = $path;
        $this->repository = $repository;
    }

    public function process()
    {
        foreach( glob($this->path) as $path ) {

            if ( null === $this->repository->findByPath($path) ) {
                $picture = new Picture();
                $picture->setPath( $path );
                $this->repository->save( $picture );
            }
        }
    }

} 