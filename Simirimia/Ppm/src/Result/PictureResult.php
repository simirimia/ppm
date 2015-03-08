<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:05
 */

namespace Simirimia\Ppm\Result;

use Simirimia\Core\Result\Result;
use Simirimia\Ppm\Entity\Picture;
use Simirimia\Core\Result\ResultCode;

class PictureResult implements Result
{
    use ResultCode;

    /**
     * @var Picture
     */
    private $picture;

    public function __construct( Picture $picture ) {
        $this->picture = $picture;
    }

    public function getData() {
        return $this->picture;
    }
} 