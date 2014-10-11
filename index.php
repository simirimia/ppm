<?php


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/aura/autoload/src/Loader.php';
//require __DIR__ . '/vendor/redbeanphp/rb.php';

$loader = new \Aura\Autoload\Loader();
$loader->addPrefix( 'Simirimia\Ppm', __DIR__ . '/Simirimia/Ppm/src' );
$loader->addPrefix( 'Psr\Http\Message', __DIR__ . '/vendor/psr/http-message/src' );
$loader->addPrefix( 'Intervention\Image', __DIR__ . '/vendor/intervention/image/src' );
$loader->register();

R::setup('mysql:host=localhost;dbname=ppm','ppm','ppmpw');

$logger = new \Monolog\Logger( 'ppm' );
$logger->pushHandler( new Monolog\Handler\StreamHandler( __DIR__ . '/ppm.log' ) );
$logger->addInfo( 'Logging inititalised' );
// ******

//var_dump( exif_read_data( '/home/verena/Bilder/BirgratenAmSchloß.jpg' ) );
//exit;

//phpinfo();

//$command = new Simirimia\Ppm\Command\ScanFolder( '/home/verena/Bilder/*.JPG' );
//$handler = new Simirimia\Ppm\CommandHandler\ScanFolder( $command, new Simirimia\Ppm\Repository\Picture() );

//$command = new Simirimia\Ppm\Command\ExtractExif();
//$handler = new Simirimia\Ppm\CommandHandler\ExtractExif( $command, new Simirimia\Ppm\Repository\Picture() );


$handler->process();

// ******

R::close();