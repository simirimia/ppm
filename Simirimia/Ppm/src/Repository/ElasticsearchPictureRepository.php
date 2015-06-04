<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 04.06.15
 * Time: 15:24
 */

namespace Simirimia\Ppm\Repository;


use Simirimia\Ppm\Entity\Picture as PictureEntity;

class ElasticsearchPictureRepository implements PictureRepository
{
    /**
     * @param PictureEntity $entity
     */
    public function save( PictureEntity $entity )
    {
        // TODO: Implement save() method.
    }

    /**
     * @param $path
     * @return null|PictureEntity
     * @throws \Exception
     */
    public function findByPath( $path )
    {
        // TODO: Implement findByPath() method.
    }

    public function findWithoutThumbnails( $limit )
    {
        // TODO: Implement findWithoutThumbnails() method.
    }

    public function findWithoutExif()
    {
        // TODO: Implement findWithoutExif() method.
    }

    public function findById( $id )
    {
        // TODO: Implement findById() method.
    }

    /**
     * @return array
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    public function findLimitedSet( $limit, $offset )
    {
        // TODO: Implement findLimitedSet() method.
    }

    public function findByTag( $tag, $limit, $offset )
    {
        // TODO: Implement findByTag() method.
    }

}