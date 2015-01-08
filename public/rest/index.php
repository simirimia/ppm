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

if ( false === isset($_SERVER['REQUEST_METHOD']) ) {
    if ( isset($_SERVER['argv'][1]) ) {
        $requestMethod = $_SERVER['argv'][1];
    } else {
        $requestMethod = 'POST';
    }
} else {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
}


switch( $requestMethod ) {
    case 'GET':
        $dispatcher = new \Simirimia\Ppm\QueryDispatcher( $logger );
        break;
    case 'DELETE':
    case 'POST':
        $dispatcher = new \Simirimia\Ppm\CommandDispatcher( $logger );
        break;
    default:
        echo json_encode( [ 'error' => 'Unknown HTTP method' ] );
        die();
}


$result = $dispatcher->dispatch( \Simirimia\Ppm\Request::createFromSuperGlobals() );


if ( $result instanceof \Simirimia\Ppm\Result\ArrayResult ) {
    echo \Simirimia\Ppm\ResultRenderer\ArrayResultRenderer::render( $result );
} elseif( $result instanceof \Simirimia\Ppm\Result\FilePathResult ) {
    echo \Simirimia\Ppm\ResultRenderer\FilePathRenderer::render( $result );
} elseif( $result instanceof \Simirimia\Ppm\Result\PictureResult ) {
    echo \Simirimia\Ppm\ResultRenderer\PictureResultRenderer::render( $result );
} elseif( $result instanceof \Simirimia\Ppm\Result\PictureCollectionResult ) {
    echo \Simirimia\Ppm\ResultRenderer\PictureCollectionResultRenderer::render( $result );
} else{
    var_dump( $result );
    die( 'Unknown return type' );
}


// ******

R::close();