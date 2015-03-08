<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 17:48
 */

namespace Simirimia\User\Command;

use Simirimia\User\Types\Email;
use Simirimia\User\Types\Password;

class Authenticate
{
    /**
     * @var Email
     */
    private $email;
    /**
     * @var Password
     */
    private $password;

    public function __construct( Email $email, Password $password )
    {
        $this->email = $email;
        $this->password = $password;
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

}