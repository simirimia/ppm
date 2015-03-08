<?php

use RedBeanPHP\R;

require __DIR__ . '/../../vendor/autoload.php';
set_error_handler('ppmErrorHandler');
ob_start();

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

$responseBody = '';
try {
    $result = $dispatcher->dispatch( $request );
    $responseBody =  \Simirimia\Core\ResultRenderer\Renderer::render( $result );
    R::close();
} catch ( Exception $e ) {
    http_response_code( 500 );
    $responseBody = json_encode( [
        'success' => false,
        'message' => 'Exception during execution of type: ' . get_class( $e ),
        'trace' => $e->getTraceAsString(),
        'additional' => ob_get_clean()
    ] );
}
ob_clean();
echo $responseBody;


function ppmErrorHandler($errno, $errstr, $errfile, $errline) {
    if ( E_RECOVERABLE_ERROR===$errno ) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
    return false;
}
