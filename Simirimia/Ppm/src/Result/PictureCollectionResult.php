<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:05
 */

namespace Simirimia\Ppm\Result;

use Simirimia\Ppm\PictureCollection;

class PictureCollectionResult
{
    /**
     * @var PictureCollection
     */
    private $data;

    public function __construct( PictureCollection $picture ) {
        $this->data = $picture;
    }

    public function getData() {
        return $this->data;
    }
} 