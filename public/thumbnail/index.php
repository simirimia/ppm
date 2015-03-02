<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/aura/autoload/src/Loader.php';

$loader = new \Aura\Autoload\Loader();
$loader->addPrefix( 'Simirimia\Ppm', __DIR__ . '/../../Simirimia/Ppm/src' );
$loader->addPrefix( 'Simirimia\User', __DIR__ . '/../../Simirimia/User/src' );
$loader->addPrefix( 'Simirimia\Core', __DIR__ . '/../../Simirimia/Core/src' );
$loader->addPrefix( 'Psr\Http\Message', __DIR__ . '/../../vendor/psr/http-message/src' );
$loader->register();

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

$uri = explode( '/', $_SERVER['REQUEST_URI'] );

$file = $config->getThumbnailPath() . '/' . str_replace( '..', '', array_pop( $uri ) );

if( false === file_exists( $file ) ) {
    die('404');
}

header('Content-type: image/jpg');
fpassthru( fopen($file, 'r') );

