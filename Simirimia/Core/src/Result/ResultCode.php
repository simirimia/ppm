<?php
/**
 * @author: https://github.com/simirimia
 * @license: @license BSD/GPL
 * @copyright:
 * copyright (c) simirima
 * This source file is subject to the BSD/GPL License that is bundled
 * with this source code in the file license.txt.
 */

namespace Simirimia\Core\Result;

use \InvalidArgumentException;

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