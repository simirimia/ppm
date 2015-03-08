<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 18:22
 */

namespace Simirimia\Core\Result;


class CompoundResult implements Result
{
    use ResultCode;

    /**
     * @var array
     */
    private $results = [];

    public function add( $result )
    {
        $this->results[] = $result;
    }

    public function getResults()
    {
        return $this->results;
    }
} 