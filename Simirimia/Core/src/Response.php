<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 18:39
 */

namespace Simirimia\Core;

use InvalidArgumentException;

abstract class Response
{
    /**
     * @var int
     */
    private $resultCode = 0;

    /**
     * @var string
     */
    private $body = '';

    /**
     * @param Request $request
     * @return Response
     */
    public static function fromRequest( Request $request )
    {
        if ( $request instanceof HttpRequest ) {
            return new HttpResponse();
        } elseif( $request instanceof ConsoleRequest ) {
            return new ConsoleResponse();
        }
        throw new InvalidArgumentException( 'Unknown $request type' );
    }

    abstract public function send();


    /**
     * @return int
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * @param int $resultCode
     */
    public function setResultCode($resultCode)
    {
        if ( !is_int( $resultCode ) ) {
            throw new InvalidArgumentException( '$resultCode must be int' );
        }
        $this->resultCode = $resultCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        if ( !is_string( $body ) ) {
            throw new InvalidArgumentException( '$body must be a string' );
        }
        $this->body = $body;
    }

    public function appendToBody( $body )
    {
        if ( !is_string( $body ) ) {
            throw new InvalidArgumentException( '$body must be a string' );
        }
        $this->body .= $body;
    }

}