<?php
/*
 * This file is part of the simirimia/core package.
 *
 * (c) https://github.com/simirimia
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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