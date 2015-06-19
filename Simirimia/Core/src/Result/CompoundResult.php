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


class CompoundResult implements Result
{
    use ResultCode;

    /**
     * @var array
     */
    private $results = [];

    /**
     * @param $result
     */
    public function add( $result )
    {
        $this->results[] = $result;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return int
     */
    public function getResultCode()
    {
        $code = -1;
        /** @var Result $result */
        foreach( $this->results as $result ) {
            if ( $result->getResultCode() > $code ) {
                $code = $result->getResultCode();
            }
        }
        return $code;
    }


} 