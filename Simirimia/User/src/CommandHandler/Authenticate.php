<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 17:50
 */

namespace Simirimia\User\CommandHandler;

use Simirimia\Core\Dispatchable;
use Simirimia\Core\Result\ArrayResult;
use Simirimia\Core\Result\Result;
use Simirimia\User\Command\Authenticate as AuthenticateCommand;
use Simirimia\User\Repository\User as UserRepository;
use Simirimia\User\Entity\User;

class Authenticate implements Dispatchable
{
    /**
     * @var AuthenticateCommand
     */
    private $command;
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct( AuthenticateCommand $command, UserRepository $repository )
    {
        $this->command = $command;
        $this->repository = $repository;
    }

    /**
     * @return Result
     */
    public function process()
    {
        $user = $this->repository->findByEmail( $this->command->getEmail() );
        if (   ! ($user instanceof User)
            || ! $user->verifyPassword( $this->command->getPassword() ) ) {
            $result = new ArrayResult( [ 'success' => false ] );
            $result->setResultCode( Result::FORBIDDEN );
            return $result;
        }

        $result = new ArrayResult( [ 'success' => true ] );
        $result->setResultCode( Result::OK );
        return $result;
    }


}