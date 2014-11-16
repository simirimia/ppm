<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 16.10.14
 * Time: 21:40
 */

namespace Simirimia\Ppm\Query;


class ThumbnailsPerTag {

    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $tag;
    /**
     * @var int
     */
    private $limit;
    /***
     * @var int
     */
    private $offset;

    public function __construct( $type, $tag, $limit, $offset )
    {
        $allowed = [ 'small', 'medium', 'large' ];
        if ( !in_array( $type, $allowed )) {
            throw new \Exception( 'Not an allowed thumbnail type' );
        }
        $this->tag = (string)$tag;
        $this->type = $type;
        $this->limit = (int)$limit;
        $this->offset = (int)$offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


} 