<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 19:03
 */

namespace Simirimia\Ppm\Query;


use InvalidArgumentException;

class TagsForPicture
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * @param int $pictureId
     * @throws InvalidArgumentException
     */
    public function __construct( $pictureId )
    {
        if ( !is_int( $pictureId ) ) {
            throw new InvalidArgumentException( 'pictureId must be integer' );
        }
        $this->id = $pictureId;
    }

    /**
     * @return int
     */
    public function getPictureId()
    {
        return $this->id;
    }
} 