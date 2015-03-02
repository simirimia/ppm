<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 02.03.15
 * Time: 08:02
 */

namespace Types;


class Password
{
    /**
     * @var string
     */
    private $password;

    /**
     * @param $passwordString
     * @return Password
     * @throws \InvalidArgumentException
     */
    public static function fromString( $passwordString )
    {
        if ( self::validateString( $passwordString ) ) {
            throw new \InvalidArgumentException( 'Password is not valid' );
        }
        return new Password( $passwordString );
    }

    /**
     * TODO
     * @param $passwordString
     * @return bool
     */
    public  static function validateString( $passwordString )
    {
        return true;
    }

    private function __construct( $passwordString )
    {
        $this->password = $passwordString;
    }


    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return password_hash( $this->password );
    }
}