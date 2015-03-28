<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 15.10.14
 * Time: 23:41
 */

namespace Simirimia\Core\Result;


class ArrayResult implements Result
{
    use ResultCode;

    /**
     * @var array
     */
    private $data;

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