<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:06
 */

namespace Simirimia\Ppm\Repository;

use Simirimia\Ppm\Entity\Picture as PictureEntity;

class Picture {

    public function save( PictureEntity $entity )
    {
        $picture = \R::dispense( 'picture' );
        $picture->isProcessed = $entity->getIsProcessed();
        $picture->path = $entity->getPath();
        \R::store( $picture );
    }

} 