<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 01.03.15
 * Time: 20:56
 */

namespace Simirimia\User\Entity;

use \DateTimeInterface;

class User
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $passwordHash;
    /**
     * @var string
     */
    private $nounce;
    /**
     * @var DateTimeInterface
     */
    private $nounceValidTo;
    /**
     * @var array
     */
    private $rights = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return string
     */
    public function getNounce()
    {
        return $this->nounce;
    }

    /**
     * @param string $nounce
     */
    public function setNounce($nounce)
    {
        $this->nounce = $nounce;
    }

    /**
     * @return DateTimeInterface
     */
    public function getNounceValidTo()
    {
        return $this->nounceValidTo;
    }

    /**
     * @param DateTimeInterface $nounceValidTo
     */
    public function setNounceValidTo($nounceValidTo)
    {
        $this->nounceValidTo = $nounceValidTo;
    }

    /**
     * @return array
     */
    public function getRights()
    {
        return $this->rights;
    }

    /**
     * @param array $rights
     */
    public function setRights($rights)
    {
        $this->rights = $rights;
    }


}