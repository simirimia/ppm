<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 02.03.15
 * Time: 08:02
 */

namespace Simirimia\User\Types;

class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param $emailString
     * @return Email
     * @throws \InvalidArgumentException
     */
    public static function fromString( $emailString )
    {
        if ( ! self::validateString( $emailString ) ) {
            throw new \InvalidArgumentException( 'E-Mail ' . $emailString . ' is not a valid e-mail' );
        }
        return new Email( $emailString );
    }

    /**
     * TODO
     * @param $emailString
     * @return bool
     */
    public  static function validateString( $emailString )
    {
        return true;
    }

    private function __construct( $emailString )
    {
        $this->email = $emailString;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}