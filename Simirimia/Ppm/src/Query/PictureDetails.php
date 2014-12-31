<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:33
 */

namespace Simirimia\Ppm\Query;


class PictureDetails {

    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct( $id ) {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


} 