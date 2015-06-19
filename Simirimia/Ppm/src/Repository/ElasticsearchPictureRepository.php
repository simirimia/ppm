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

    private $type = 'picture';

    private $host;
    private $index;
    private $user;
    private $password;

    public function __construct( $host, $index, $user, $password )
    {
        $this->host = $host;
        $this->index = $index;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param PictureEntity $entity
     */
    public function save( PictureEntity $entity )
    {
        if ( $entity->getId() == '' ) {
            $id = uniqid();
            $entity->setId( $id );
        } else {
            $id = $entity->getId();
        }

        $this->toElasticSearch( 'PUT', $id, $this->entityToJson( $entity ) );
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
        // TODO: HOW TO FILTER FOR EMPTY ARRAYS????

        $query = new \stdClass();
        $query->query = new \stdClass();
        $query->query->constant_score = new \stdClass();
        $query->query->constant_score->filter = new \stdClass();
        $query->query->constant_score->filter->term = new \stdClass();
        $query->query->constant_score->filter->term->exifExtracted = false;
        $data = json_encode( $query );

        $result = $this->toElasticSearch( 'POST', '_search', $data );

        $result = json_decode( $result );

        foreach( $result->hits->hits as $current ) {
            $this->popoToEntity( $current->source );
        }

        return $result;
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

    private function toElasticSearch( $type, $resource, $data )
    {
        $cmd = <<<cmd
curl -X$type "http://{$this->host}/{$this->index}/{$this->type}/{$resource}" -d '{$data}'
cmd;

        $output = [];

        exec( $cmd, $output );

        return $output[0];



        /*
        $handle = \curl_init( "http://".$this->host.'/'.$this->index.'/'.$this->type.'/'.$resource );
        $success = false;
        if ( $type == 'PUT' ) {
            $success = curl_setopt_array( $handle, [
                CURLOPT_PUT => true,
                CURLOPT_INFILE => $data,
                CURLOPT_INFILESIZE => strlen($data),
                CURLOPT_RETURNTRANSFER => true
            ] );
        }
        if ( !$success ) {
            throw new \Exception( 'Invalid curl option or request type' );
        }

        $result = curl_exec( $handle );
        return $result;
        */
    }

    private function entityToJson( PictureEntity $entity )
    {
        $popo = new \stdClass();

        $exifComplete = $entity->getExifComplete();
        $exif = $entity->getExif();
        $popo->path = $entity->getPath();
        $popo->thumbSmall = $entity->getThumbSmall();
        $popo->thumbMedium = $entity->getThumbMedium();
        $popo->thumbLarge = $entity->getThumbLarge();
        $popo->exifComplete = $exifComplete;
        $popo->exif = $exif;
        $popo->exifExtracted = $entity->isExifExtracted();

        $alternative = $entity->getIsAlternativeTo();
        if ( $alternative === null ) {
            $popo->isAlternativeTo = 0;
        } else {
            $popo->isAlternativeTo = $alternative->getId();
        }

        $popo->hasAternatives = $entity->getHasAlternatives();
        $popo->isInGallery = $entity->isInGallery();

        $popo->tags = $entity->getTags();

        return json_encode( $popo );
    }

}