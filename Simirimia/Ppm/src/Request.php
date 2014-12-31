<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 14.10.14
 * Time: 23:02
 */

namespace Simirimia\Ppm;


class Request
{
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
        $url = explode( '?', $url );
        $url = array_shift( $url );

        return new Request( $url, $_GET, file_get_contents('php://input') );
    }

    public function __construct( $url, array $queryParams, $body )
    {
        $this->url = (string)$url;
        $this->body = $body;

        $this->page = isset($queryParams['page']) ? $queryParams['page'] : 1;
        $this->pageSize = isset($queryParams['pageSize']) ? $queryParams['pageSize'] : 20;
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



} 