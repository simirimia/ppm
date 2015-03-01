<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 14.10.14
 * Time: 23:02
 */

namespace Simirimia\Core;


class Request
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

    public static function createFromSuperGlobals()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
        } elseif ($_SERVER['argv'][2]) {
            $url = $_SERVER['argv'][2];
        } else {
            //$url = "/rest/pictures/thumbnails/create";
            //$url = "/rest/pictures/thumbnails/small";
            //$url = '/rest/pictures/scan';
            //$url = '/rest/picture/extract-exif';
            $url = '';
        }

        if (isset($_SERVER['REQUEST_METHOD'])) {
            $method = $_SERVER['REQUEST_METHOD'];
        } elseif( isset($_SERVER['argv'][1]) ) {
            $method = $_SERVER['argv'][1];
        } else {
            $method = 'POST';
        }

        $url = explode( '?', $url );
        $url = array_shift( $url );

        return new Request( $url, $_GET, file_get_contents('php://input'), $method );
    }

    public function __construct( $url, array $queryParams, $body, $requestMethod )
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