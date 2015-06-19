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

use LogicException;

abstract class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';
    const PUT = 'PUT';

    /**
     * @var string
     */
    private $url;
    /***
     * @var int
     */
    private $page;
    /**
     * @var int
     */
    private $pageSize;
    /**
     * @var string
     */
    private $body;
    /**
     * @var string
     */
    private $method;

    /**
     * @return Request
     */
    public static function fromSuperGlobals()
    {
        if ( isset($_SERVER['argv']) ) {
            $class = '\Simirimia\Core\ConsoleRequest';
        } elseif( isset( $_SERVER['REQUEST_URI'] ) ) {
            $class = '\Simirimia\Core\HttpRequest';
        } else {
            throw new LogicException( 'Cannot find appropriate request class' );
        }

        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
        } elseif ($_SERVER['argv'][2]) {
            $url = $_SERVER['argv'][2];
        } else {
            $url = '/';
        }
        $url = explode('?', $url);
        $url = array_shift($url);

        if (false === isset($_SERVER['REQUEST_METHOD'])) {
            if (isset($_SERVER['argv'][1])) {
                $method = $_SERVER['argv'][1];
            } else {
                $method = 'POST';
            }
        } else {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        $body = isset($_SERVER['argv'][3]) ? $_SERVER['argv'][3] : file_get_contents('php://input');
        return new $class($url, $_GET, $body, $method);
    }

    public function __construct($url, array $queryParams, $body, $requestMethod)
    {
        $this->url = (string)$url;
        $this->body = $body;

        $this->page = isset($queryParams['page']) ? $queryParams['page'] : 1;
        $this->pageSize = isset($queryParams['pageSize']) ? $queryParams['pageSize'] : 20;

        $this->method = $requestMethod;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}
