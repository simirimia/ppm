<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 11.10.14
 * Time: 20:56
 */

namespace Simirimia\Core;

use Monolog\Logger;

abstract class Dispatcher
{
    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    public function __construct( Logger $logger, Config $config )
    {
        $this->logger = $logger;
    }

    public function dispatch( Request $request )
    {
        $handler = $this->resolveUrl( $request );

        if ( $handler === null ) {
            return [ 'error' => 'No handler found' ];
        }

        if ( !($handler instanceof Dispatchable) ) {
            return [ 'error' => 'handler is not a dispatchable' ];
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

    protected abstract function resolveUrl( Request $request );

} 