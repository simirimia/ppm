<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:06
 */

namespace Simirimia\Ppm\Repository;

use Simirimia\Ppm\Entity\Picture as PictureEntity;
use \R;

class Picture {

    /**
     * @param PictureEntity $entity
     */
    public function save( PictureEntity $entity )
    {
        R::store( $this->entityToBean( $entity ) );
    }

    /**
     * @param $path
     * @return null|PictureEntity
     * @throws \Exception
     */
    public function findByPath( $path )
    {
        $bean = R::findOne( 'picture', 'path = ? ', [ $path ] );
        if ( empty($bean) ) {
            return null;
        }

        return $this->beanToEntity( $bean );
    }

    public function findWithoutThumbnails()
    {
        $data = R::find( 'picture', "thump_small =''" );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $data = R::findAll( 'picture' );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    public function findLimitedSet( $limit, $offset )
    {
        $limit = (int)$limit;
        $offset = (int)$offset;
        $data = R::getAll( 'SELECT * FROM picture LIMIT ' . $limit . ' OFFSET ' . $offset );
        $data = R::convertToBeans( 'picture', $data );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    /**
     * @param $bean
     * @return PictureEntity
     */
    private function beanToEntity( $bean )
    {
        $entity = new PictureEntity();
        $entity->setId($bean->id);
        $entity->setPath($bean->path);
        $entity->setThumbSmall( $bean->thumbSmall );
        $entity->setThumbMedium( $bean->thumbMedium );
        $entity->setThumbLarge( $bean->thumbLarge );
        $entity->setExifComplete( @unserialize( $bean->exifComplete ) );
        $entity->setExif( @unserialize($bean->exif) );

        $tags = R::tag( $bean );

        $entity->setTags( $tags );

        return $entity;
    }


    /**
     * @param PictureEntity $entity
     * @return \OODBBean
     */
    private function entityToBean( PictureEntity $entity )
    {
        if ( empty($entity->getId()) ) {
            $bean = R::dispense( 'picture' );
        } else {
            $bean = R::load( 'picture', $entity->getId() );
        }

        $exifComplete = $entity->getExifComplete();
        $exifComplete = serialize( $exifComplete );

        $exif = $entity->getExif();
        $exif = serialize( $exif );

        $bean->path = $entity->getPath();
        $bean->thumbSmall = $entity->getThumbSmall();
        $bean->thumbMedium = $entity->getThumbMedium();
        $bean->thumbLarge = $entity->getThumbLarge();
        $bean->exifComplete = $exifComplete;
        $bean->exif = $exif;

        R::tag( $bean, $entity->getTags() );

        return $bean;
    }

}