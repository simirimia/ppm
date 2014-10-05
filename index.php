<?php

require __DIR__ . '/vendor/aura/autoload/src/Loader.php';
require __DIR__ . '/vendor/redbeanphp/rb.php';

$loader = new \Aura\Autoload\Loader();
$loader->addPrefix( 'Simirimia\Ppm', __DIR__ . '/Simirimia/Ppm/src' );
$loader->addPrefix( 'Psr\Http\Message', __DIR__ . '/vendor/psr/http-message/src' );
$loader->register();

R::setup('mysql:host=localhost;dbname=ppm','ppm','ppmpw');

// ******


$command = new Simirimia\Ppm\Command\ScanFolder( '/home/verena/Bilder/*.jpg' );

$handler = new Simirimia\Ppm\CommandHandler\ScanFolder( $command, new Simirimia\Ppm\Repository\Picture() );

$handler->process();

// ******

R::close();