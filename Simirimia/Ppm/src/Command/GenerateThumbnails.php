<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:31
 */

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\Repository\Picture as PictureRepository;
use Simirimia\Ppm\Entity\Picture;

class GenerateThumbnails {

    /**
     * @var \Simirimia\Ppm\Repository\Picture
     */
    private $repository;

    public function __construct( PictureRepository $repository )
    {
        $this->repository = $repository;
    }

    public function process()
    {
        $allP
    }

} 