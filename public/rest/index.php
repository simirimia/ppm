<?php

use RedBeanPHP\R;

require __DIR__ . '/../../vendor/autoload.php';

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

R::setup( $config->getDatabaseDsn(), $config->getDatabaseUser(), $config->getDatabasePassword() );

$logger = new \Monolog\Logger( 'ppm' );
$logger->pushHandler( new Monolog\Handler\StreamHandler( __DIR__ . '/../../log/ppm.log' ) );
$logger->addInfo( 'Logging started' );

$request = \Simirimia\Core\Request::createFromSuperGlobals();

switch( $request->getMethod() ) {
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


$result = $dispatcher->dispatch( $request );


echo \Simirimia\Core\ResultRenderer\Renderer::render( $result );


R::close();