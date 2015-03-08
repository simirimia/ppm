<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 01.03.15
 * Time: 23:30
 */

namespace Simirimia\User\Repository;

use RedBeanPHP\R;
use Simirimia\User\Entity\User as UserEntity;
use Simirimia\User\Types\Email;
use Simirimia\User\Types\Password;

class User
{
    /**
     * @param $id
     * @return null|UserEntity
     */
    public function findById( $id )
    {
        $id = (int)$id;
        $bean = R::load( 'user', $id );
        if ( empty($bean) ) {
            return null;
        }
        return $this->beanToEntity( $bean );
    }

    /**
     * @param $email
     * @return null|UserEntity
     */
    public function findByEmail( Email $email )
    {
        $bean = R::findOne( 'user', 'email = ?', [ $email->getEmail() ] );
        if ( empty( $bean ) ) {
            return null;
        }
        return $this->beanToEntity( $bean );
    }

    public function findByEmailAndPassword( Email $email, Password $password )
    {
        $bean = R::findOne( 'user', 'email = ? AND password_hash = ? ',
            [ $email->getEmail(), $password->getPasswordHash() ] );
        if ( empty( $bean ) ) {
            return null;
        }
        return $this->beanToEntity( $bean );
    }

    /**
     * @param UserEntity $entity
     */
    public function save( UserEntity $entity )
    {
        R::store( $this->entityToBean( $entity ) );
    }

    /**
     * @param $bean
     * @return UserEntity
     */
    private function beanToEntity( $bean )
    {
        $entity = new UserEntity();
        $entity->setId( $bean->id );
        $entity->setEmail( Email::fromString( $bean->email ) );
        $entity->setFirstName( $bean->firstName );
        $entity->setLastName( $bean->lastName );
        $entity->setPasswordHash( $bean->passwordHash );
        $entity->setRights( unserialize( $bean->rights ) );

        return $entity;
    }

    /**
     * @param UserEntity $entity
     * @return array|\RedBeanPHP\OODBBean
     * @throws \RedBeanPHP\RedException
     */
    private function entityToBean( UserEntity $entity )
    {
        if ( $entity->getId() == 0 ) {
            $bean = R::dispense( 'user' );
        } else {
            $bean = R::load( 'user', $entity->getId() );
        }

        $bean->email = $entity->getEmail()->getEmail();
        $bean->firstName = $entity->getFirstName();
        $bean->lastName = $entity->getLastName();
        $bean->passwordHash = $entity->getPasswordHash();
        $bean->rights = serialize( $entity->getRights() );

        return $bean;
    }
}