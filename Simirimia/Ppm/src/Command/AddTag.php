<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 18.09.14
 * Time: 23:31
 */

namespace Simirimia\Ppm\Command;


class AddTag {

    /***
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $tag;

    public function __construct( $id, $tag )
    {
        if( !is_int($id) ) {
            throw new \Exception( 'ID must be an integer' );
        }
        if ( !is_string($tag) ) {
            throw new \Exception( 'Tag must be a string' );
        }
        $this->id = $id;
        $this->tag = $tag;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

}