<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:06
 */

namespace Simirimia\Ppm\Repository;

use Simirimia\Ppm\Entity\Picture as PictureEntity;
use RedBeanPHP\R;
use Simirimia\Ppm\PictureCollection;

class Picture {

    private $identityMap = [];

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

    public function findWithoutThumbnails( $limit )
    {
        $data = R::find( 'picture', "thumb_small ='' AND exif_complete != 'a:0:{}' LIMIT ?", [$limit] );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    public function findWithoutExif()
    {
        $data = R::find( 'picture', "exif_complete='a:0:{}'" );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    public function findById( $id )
    {
        $id = (int)$id;
        $bean = R::load( 'picture', $id );
        if ( empty($bean) ) {
            return null;
        }

        return $this->beanToEntity( $bean );
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
        //$data = R::getAll( 'SELECT * FROM picture WHERE is_alternative_to = 0 LIMIT ' . $limit . ' OFFSET ' . $offset );
        //$data = R::convertToBeans( 'picture', $data );
        $data = R::findAll( 'picture', 'is_alternative_to = 0 ORDER By id DESC LIMIT ?  OFFSET ?', [$limit, $offset] );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    public function findByTag( $tag, $limit, $offset )
    {
        $limit = (int)$limit;
        $offset = (int)$offset;

        //$data = R::tagged( 'picture', [$tag] );
        //$data = array_slice( $data, $offset, $limit );

        $data = R::getAll( 'SELECT p.*
                            FROM picture p
                            JOIN picture_tag pt ON p.id=pt.picture_id
                            JOIN tag t ON t.id = pt.tag_id
                            WHERE p.is_alternative_to = 0
                            AND t.title = ?
                            LIMIT ?
                            OFFSET ?',

            [$tag, $limit, $offset]
        );

        $data = R::convertToBeans( 'picture', $data );
        $result = [];

        foreach( $data as $bean ) {
            $result[] = $this->beanToEntity( $bean );
        }
        return $result;
    }

    private function getAlternatives( $id ) {
        $data = R::findAll( 'picture', 'is_alternative_to = ? ', [$id] );
        $result = new PictureCollection();

        foreach( $data as $bean ) {
            $result->add( $this->beanToEntity( $bean ) );
        }
        return $result;
    }

    /**
     * @param $bean
     * @return PictureEntity
     */
    private function beanToEntity( $bean )
    {

        // first check if the corresponding entity is already loaded and stored in the identity map
        if( isset( $this->identityMap[$bean->id] )
        && $this->identityMap[$bean->id] instanceof PictureEntity ) {
            return $this->identityMap[$bean->id];
        }

        $entity = new PictureEntity();
        $entity->setId($bean->id);
        $entity->setPath($bean->path);
        $entity->setThumbSmall( $bean->thumbSmall );
        $entity->setThumbMedium( $bean->thumbMedium );
        $entity->setThumbLarge( $bean->thumbLarge );
        $entity->setExifComplete( @unserialize( $bean->exifComplete ) );
        $entity->setExif( @unserialize($bean->exif) );
        $entity->setHasAlternatives( $bean->hasAternatives );

        $tags = R::tag( $bean );
        $entity->setTags( $tags );

        $this->identityMap[$entity->getId()] = $entity;

        if ( $bean->isAlternativeTo > 0 ) {
            $entity->setIsAlternativeTo( $this->findById( $bean->isAlternativeTo ) );
        }

        if ( $entity->getHasAlternatives() ) {
            $entity->setAlternatives( $this->getAlternatives( $entity->getId() ) );
        }

        return $entity;
    }


    /**
     * @param PictureEntity $entity
     * @return \OODBBean
     */
    private function entityToBean( PictureEntity $entity )
    {
        if ( $entity->getId() == 0 ) {
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

        $alternative = $entity->getIsAlternativeTo();
        if ( $alternative === null ) {
            $bean->isAlternativeTo = 0;
        } else {
            $bean->isAlternativeTo = $alternative->getId();
        }

        $bean->hasAternatives = $entity->getHasAlternatives();



        R::tag( $bean, $entity->getTags() );

        return $bean;
    }

}