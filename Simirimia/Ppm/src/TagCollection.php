<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 16:06
 */

namespace Simirimia\Ppm;

use Simirimia\Core\ArrayCollection;

class TagCollection extends ArrayCollection
{

    public function __construct()
    {
        parent::__construct( 'Simirimia\Ppm\Entity\Tag', 'getId');
    }


} 