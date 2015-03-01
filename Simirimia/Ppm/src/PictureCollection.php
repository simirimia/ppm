<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:19
 */

namespace Simirimia\Ppm;

use Simirimia\Core\ArrayCollection;

class PictureCollection extends ArrayCollection
{

    public function __construct()
    {
        parent::__construct( 'Simirimia\Ppm\Entity\Picture', 'getId');
    }

}
