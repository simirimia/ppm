<?php

namespace Simirimia\Ppm\Command;

class ScanFolder {

    /**
     * @var string
     */
    private $path;

    public function __construct( $pictureSourcePath )
    {
        if ( !is_string( $pictureSourcePath) ) {
            throw new \InvalidArgumentException( '$pictureSourcePath needs to be string' );
        }
        $this->path = $pictureSourcePath;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


} 