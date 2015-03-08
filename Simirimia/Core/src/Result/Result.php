<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 07.03.15
 * Time: 15:27
 */

namespace Simirimia\Core\Result;


interface Result
{
    const OK = 200;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const BACKEND_ERROR = 500;

    /**
     * @return int
     */
    public function getResultCode();

    /**
     * @param int $resultCode
     */
    public function setResultCode( $resultCode );
}