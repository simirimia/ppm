<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.02.15
 * Time: 17:56
 */

namespace Simirimia\Ppm\Command;


class UpdateTagCount
{
    /**
     * @var string
     */
    private $tag = '';

    /**
     * @param string $tag
     */
    public function __construct( $tag = '' )
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

} 