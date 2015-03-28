<?php

use RedBeanPHP\R;

require __DIR__ . '/../../vendor/autoload.php';
set_error_handler('ppmErrorHandler');

if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
    header('WWW-Authenticate: Basic realm="P Picture Manager"');
    http_response_code( 401 );
    die('401');
}

ob_start();

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

R::setup( $config->getDatabaseDsn(), $config->getDatabaseUser(), $config->getDatabasePassword() );

$logger = new \Monolog\Logger( 'ppm' );
$logger->pushHandler( new Monolog\Handler\StreamHandler( __DIR__ . '/../../log/ppm.log' ) );
$logger->addInfo( 'Logging started' );


$authCommand = new \Simirimia\User\CommandHandler\Authenticate(
    new \Simirimia\User\Command\Authenticate(
            \Simirimia\User\Types\Email::fromString($_SERVER['PHP_AUTH_USER']),
            \Simirimia\User\Types\Password::fromString($_SERVER['PHP_AUTH_PW'])
        ),
    new \Simirimia\User\Repository\User()
);
if ( $authCommand->process()->getResultCode() != \Simirimia\Core\Result\Result::OK ) {
    http_response_code( 403 );
    die('403');
}



$request = \Simirimia\Core\Request::fromSuperGlobals();
$response = \Simirimia\Core\Response::fromRequest( $request );

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
    \Simirimia\Ppm\ResultRenderer\Renderer::render( $result, $response );
    R::close();
} catch ( Exception $e ) {
    $response->setResultCode( \Simirimia\Core\Result\Result::BACKEND_ERROR );
    $response->setBody( json_encode( [
        'success' => false,
        'message' => 'Exception during execution of type: ' . get_class( $e ),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
        'additional' => ob_get_clean()
    ] ) );
}
ob_clean();
$response->send();

function ppmErrorHandler($errno, $errstr, $errfile, $errline) {
    if ( E_RECOVERABLE_ERROR===$errno ) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
    return false;
}
