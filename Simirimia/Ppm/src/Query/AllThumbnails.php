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

    public function __construct( $type )
    {
        $allowed = [ 'small', 'medium', 'large' ];
        if ( !in_array( $type, $allowed )) {
            throw new \Exception( 'Not an allowed thumbnail type' );
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


} 