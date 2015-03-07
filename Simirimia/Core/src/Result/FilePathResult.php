<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:44
 */

namespace Simirimia\Core\Result;


class FilePathResult implements Result
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $mimeType;

    public function __construct( $path, $mimeType )
    {
        $this->path = (string)$path;
        $this->mimeType = (string)$mimeType;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

}