<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 15:11
 */

namespace Simirimia\Ppm\Repository;

use \R;
use Simirimia\Ppm\TagCollection;
use Simirimia\Ppm\Entity\Tag as TagEntity;

class Tag
{
    /**
     * @return TagCollection
     */
    public function findAll()
    {
        $data = R::getAll( 'SELECT * FROM tag t ORDER BY t.counter' );
        $collection = new TagCollection();

        foreach( $data as $current ) {
            $collection->add( $this->arrayToEntity($current) );
        }
        return $collection;
    }

    private function arrayToEntity( array $data )
    {
        $entity = new TagEntity();
        $entity->setId( $data['id'] );
        $entity->setTitle( $data['title'] );
        $entity->setCount( $data['counter'] );
        return $entity;
    }
} 