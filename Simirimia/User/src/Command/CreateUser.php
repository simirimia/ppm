<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 02.03.15
 * Time: 07:57
 */

namespace Simirimia\User\Command;

use Simirimia\User\Types\Email;
use Simirimia\User\Types\Password;

use InvalidArgumentException;

class CreateUser
{
    /**
     * @var Email
     */
    private $email;
    /**
     * @var Password
     */
    private $password;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;

    /**
     * @param Email $email
     * @param Password $password
     * @param $firstName
     * @param $lastName
     * @throws InvalidArgumentException
     */
    public function __construct( Email $email, Password $password, $firstName, $lastName )
    {
        if ( !is_string($firstName) ) {
            throw new InvalidArgumentException( 'First name needs to be a string' );
        }
        if ( !is_string($lastName) ) {
            throw new InvalidArgumentException( 'Last name needs to be a string' );
        }

        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }


}