<?php

use RedBeanPHP\R;
require __DIR__ . '/../../vendor/autoload.php';

if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
    header('WWW-Authenticate: Basic realm="P Picture Manager"');
    http_response_code( 401 );
    die('401');
}

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

$logger = new \Monolog\Logger( 'ppm' );
$logger->pushHandler( new Monolog\Handler\StreamHandler( __DIR__ . '/../../log/ppm.log' ) );
$logger->addInfo( 'Logging started' );

R::setup( $config->getUserDatabaseDsn(), $config->getUserDatabaseUser(),
    $config->getUserDatabasePassword(), false, 'user' );
R::selectDatabase( 'user' );
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

$config = \Simirimia\Ppm\Config::fromIniFilesInFolder( __DIR__ . '/../../config/' );

$uri = explode( '/', $_SERVER['REQUEST_URI'] );
$path = array_pop( $uri );

if ( preg_match( '#\.\.#', $path ) ) {
    http_response_code( 404 );
    die( 'Nope' );
}


R::setup( $config->getPictureDatabaseDsn(), $config->getPictureDatabaseUser(),
    $config->getPictureDatabasePassword(), false, 'picture' );
R::selectDatabase( 'picture' );

// remove all params
$path = array_shift(explode( '?', $path ));

$file = $config->getThumbnailPath() . '/' . $path;

if( false === file_exists( $file ) ) {
    http_response_code( 404 );
    die('404');
}

header('Content-type: image/jpg');
fpassthru( fopen($file, 'r') );

