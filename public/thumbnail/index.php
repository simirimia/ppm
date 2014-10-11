<?php

require_once __DIR__ . '/../../Simirimia/Ppm/src/Config.php';

$config = new \Simirimia\Ppm\Config();

$uri = explode( '/', $_SERVER['REQUEST_URI'] );

$file = $config->getThumbnailPath() . '/' . array_pop( $uri );

if( false === file_exists( $file ) ) {
    die('404');
}

header('Content-type: image/jpg');
fpassthru( fopen($file, 'r') );

