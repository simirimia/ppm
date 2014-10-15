<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:45
 */

namespace Simirimia\Ppm;


class ArrayResultRenderer
{
    /**
     * @var ArrayResult
     */
    private $result;

    public function __construct( ArrayResult $result )
    {
        $this->result = $result;
    }

    public function render()
    {
        echo json_encode( $this->result->getData() );
    }
} 