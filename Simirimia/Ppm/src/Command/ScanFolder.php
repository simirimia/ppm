<?php

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\PpmConfig;

class ScanFolder {

    /**
     * @var string
     */
    private $path;

    public function __construct( PpmConfig $config )
    {
        $this->path = $config->getSourcePicturePath();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


} 