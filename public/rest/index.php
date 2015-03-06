<?php

use RedBeanPHP\R;

require __DIR__ . '/../../vendor/autoload.php';

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

R::setup( $config->getDatabaseDsn(), $config->getDatabaseUser(), $config->getDatabasePassword() );

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
        $dispatcher = new \Simirimia\Ppm\QueryDispatcher( $logger, $config );
        break;
    case 'DELETE':
    case 'POST':
        $dispatcher = new \Simirimia\Ppm\CommandDispatcher( $logger, $config );
        break;
    default:
        echo json_encode( [ 'error' => 'Unknown HTTP method' ] );
        die();
}


$result = $dispatcher->dispatch( \Simirimia\Core\Request::createFromSuperGlobals() );


renderResult( $result );


function renderResult( $result )
{
    if ( $result instanceof \Simirimia\Core\Result\ArrayResult ) {
        echo \Simirimia\Core\ResultRenderer\ArrayResultRenderer::render( $result );
    } elseif( $result instanceof \Simirimia\Core\Result\FilePathResult ) {
        echo \Simirimia\Core\ResultRenderer\FilePathRenderer::render( $result );
    } elseif( $result instanceof \Simirimia\Ppm\Result\PictureResult ) {
        echo \Simirimia\Ppm\ResultRenderer\PictureResultRenderer::render( $result );
    } elseif( $result instanceof \Simirimia\Ppm\Result\PictureCollectionResult ) {
        echo \Simirimia\Ppm\ResultRenderer\PictureCollectionResultRenderer::render( $result );
    } elseif( $result instanceof \Simirimia\Core\Result\CompoundResult ) {
        $results = $result->getResults();
        $total = '[';
        foreach( $results as $current ) {
            ob_start();
            renderResult( $current );
            $total .= ob_get_clean() . ', ';
        }
        $total .= ' {} ] ';
        echo $total;
    } else{
        echo " *** UNKNOWN RESULT TYPE *** ";
        var_dump( $result );
    }
}

// ******

R::close();