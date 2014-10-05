<?php

namespace Simirimia\Ppm\Command;

class ScanFolder {

    /**
     * @var string
     */
    private $path;

    public function __construct( $path )
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


} 