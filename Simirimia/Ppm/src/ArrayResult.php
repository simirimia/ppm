<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:41
 */

namespace Simirimia\Ppm;


class ArrayResult
{
    /**
     * @var array
     */
    private $data;

    public function __construct( array $data )
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


} 