<?php


require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/aura/autoload/src/Loader.php';

$loader = new \Aura\Autoload\Loader();
$loader->addPrefix( 'Simirimia\Ppm', __DIR__ . '/../../Simirimia/Ppm/src' );
$loader->addPrefix( 'Psr\Http\Message', __DIR__ . '/../../vendor/psr/http-message/src' );
$loader->addPrefix( 'Intervention\Image', __DIR__ . '/../../vendor/intervention/image/src' );
$loader->register();

R::setup('mysql:host=localhost;dbname=ppm','ppm','ppmpw');

$logger = new \Monolog\Logger( 'ppm' );
$logger->pushHandler( new Monolog\Handler\StreamHandler( __DIR__ . '/../../log/ppm.log' ) );
$logger->addInfo( 'Logging started' );

if ( false === isset($_SERVER['REQUEST_METHOD']) )
{
    $_SERVER['REQUEST_METHOD'] = 'POST';
}

switch( $_SERVER['REQUEST_METHOD'] ){
    case 'GET':
        $dispather = new \Simirimia\Ppm\QueryDispatcher( $logger );
        break;
    case 'POST':
        $dispather = new \Simirimia\Ppm\CommandDispatcher( $logger );
        break;
    default:
        echo json_encode( [ 'error' => 'Unknown HTTP method' ] );
}


if (isset($_SERVER['REQUEST_URI'])) {
    $url = $_SERVER['REQUEST_URI'];
} else {
    //$url = "/rest/pictures/thumbnails/create";
    //$url = "/rest/pictures/thumbnails/small";
    $url = '/rest/pictures/scan';
    //$url = '/rest/picture/extract-exif';
}

$result = $dispather->dispatch( $url );

echo json_encode( $result );


// ******

R::close();