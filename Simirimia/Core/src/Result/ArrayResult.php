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


class ArrayResult implements Result
{
    use ResultCode;

    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     * @param int|null $resultCode
     */
    public function __construct( array $data, $resultCode = null )
    {
        $this->data = $data;
        if ( null !== $resultCode ) {
            if ( is_int( $resultCode ) ) {
                $this->setResultCode( $resultCode );
            } else {
                throw new \InvalidArgumentException( '$resultCode needs to be integer or omitted' );
            }
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


} 