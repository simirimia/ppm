<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 02.03.15
 * Time: 08:14
 */

namespace Simirimia\User\CommandHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\Result;
use Simirimia\User\Command\CreateUser as CreateUserCommand;
use Simirimia\User\Repository\User as UserRepository;
use Simirimia\User\Entity\User;
use Simirimia\Core\Result\ArrayResult;

class CreateUser implements Dispatchable
{
    /**
     * @var CreateUserCommand
     */
    private $command;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct( CreateUserCommand $command, UserRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    public function process()
    {
        $user = new User();
        $user->setFirstName( $this->command->getFirstName() );
        $user->setLastName( $this->command->getLastName() );
        $user->setEmail( $this->command->getEmail() );
        $user->setPasswordHash( $this->command->getPassword()->getPasswordHash() );

        $this->repository->save( $user );
        $result = new ArrayResult( [ 'success' => true ] );
        $result->setResultCode( Result::OK );
        return $result;
    }

}