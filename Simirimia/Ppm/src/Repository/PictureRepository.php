<?php
/**
 * This file is part of PPM by simirimia
 *
 * Date: 04.06.15
 * Time: 15:02
 */
namespace Simirimia\Ppm\Repository;

use Simirimia\Ppm\Entity\Picture as PictureEntity;

interface PictureRepository
{
    /**
     * @param PictureEntity $entity
     */
    public function save( PictureEntity $entity );

    /**
     * @param $path
     * @return null|PictureEntity
     * @throws \Exception
     */
    public function findByPath( $path );

    public function findWithoutThumbnails( $limit );

    public function findWithoutExif();

    public function findById( $id );

    /**
     * @return array
     */
    public function findAll();

    public function findLimitedSet( $limit, $offset );

    public function findByTag( $tag, $limit, $offset );
}