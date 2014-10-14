<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:33
 */

namespace Simirimia\Ppm\Query;


class AllThumbnails
{

    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $limit;
    /***
     * @var int
     */
    private $offset;

    public function __construct( $type, $limit, $offset )
    {
        $allowed = [ 'small', 'medium', 'large' ];
        if ( !in_array( $type, $allowed )) {
            throw new \Exception( 'Not an allowed thumbnail type' );
        }
        $this->type = $type;
        $this->limit = (int)$limit;
        $this->offset = (int)$offset;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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


} 