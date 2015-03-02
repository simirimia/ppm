<?php

require __DIR__ . '/../../vendor/autoload.php';

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

$uri = explode( '/', $_SERVER['REQUEST_URI'] );

$file = $config->getThumbnailPath() . '/' . str_replace( '..', '', array_pop( $uri ) );

if( false === file_exists( $file ) ) {
    die('404');
}

header('Content-type: image/jpg');
fpassthru( fopen($file, 'r') );

