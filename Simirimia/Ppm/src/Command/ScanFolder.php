<?php

namespace Simirimia\Ppm\Command;

use Simirimia\Ppm\Config;

class ScanFolder {

    /**
     * @var string
     */
    private $path;

    public function __construct( Config $config )
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