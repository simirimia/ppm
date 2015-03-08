<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 18:24
 */

namespace Simirimia\Core\Result;

use InvalidArgumentException;

trait ResultCode
{
    /**
     * @var
     */
    private $resultCode;

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
    public function setResultCode( $resultCode )
    {
        if ( !is_int( $resultCode ) ) {
            throw new InvalidArgumentException( '$resultCode needs to be an integer' );
        }
        $this->resultCode = $resultCode;
    }
}