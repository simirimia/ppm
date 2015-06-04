<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:56
 */

namespace Simirimia\Core;

use Intervention\Image\Exception\InvalidArgumentException;
use Monolog\Logger;
use RedBeanPHP\RedException;
use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\Result;

use Simirimia\Ppm\PpmConfigUser;
use Simirimia\Ppm\Repository\RedbeanPictureRepository;
use RedBeanPHP\R;

use Simirimia\Ppm\Repository\ElasticsearchPictureRepository;

abstract class Dispatcher
{
    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @var PpmConfigUser
     */
    private $config;

    public function __construct( Logger $logger, Config $config )
    {
        $this->logger = $logger;
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return Result
     */
    public function dispatch( Request $request )
    {
        $handler = $this->resolveUrl( $request );

        if ( $handler === null ) {
            $result = new ArrayResult( [ 'error' => 'No handler found' ] );
            $result->setResultCode( Result::NOT_FOUND );
            return $result;
        }

        if ( !($handler instanceof Dispatchable) ) {
            $result = new ArrayResult( [ 'error' => 'handler is not a dispatchable' ] );
            $result->setResultCode( Result::BACKEND_ERROR );
            return $result;
        }

        return $handler->process();
    }

    /**
     * @return Logger
     */
    protected function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return Config
     */
    protected function getConfig()
    {
        return $this->config;
    }

    protected function getPictureRepository()
    {
        switch( $this->config->getRepositoryType() ) {
            case 'redbean':

                try {
                    R::setup( $this->config->getPictureDatabaseDsn(), $this->config->getPictureDatabaseUser(),
                        $this->config->getPictureDatabasePassword(), false, 'picture' );
                } catch( RedException $e ) {
                    R::selectDatabase( 'picture' );
                }

                return new RedbeanPictureRepository();
            case 'elasticsearch':
                return new ElasticsearchPictureRepository();
        }
        throw new InvalidArgumentException( 'Unknown repository type: ' . $this->config->getRepositoryType() );
    }

    protected abstract function resolveUrl( Request $request );

} 