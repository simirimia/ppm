<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

    /**
     * output data
     */
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

    /**
     * @param $body
     */
    public function appendToBody( $body )
    {
        if ( !is_string( $body ) ) {
            throw new InvalidArgumentException( '$body must be a string' );
        }
        $this->body .= $body;
    }

}