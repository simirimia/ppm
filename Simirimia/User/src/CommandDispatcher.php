<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.03.15
 * Time: 09:58
 */

namespace Simirimia\User;

use \Simirimia\Core\Dispatcher;
use \Simirimia\Core\Request;
use Simirimia\User\Command\Authenticate;
use \Simirimia\User\Repository\User as UserRepository;
use \Simirimia\User\Types\Email;
use \Simirimia\User\Types\Password;
use \InvalidArgumentException;

class CommandDispatcher extends Dispatcher
{
    protected function resolveUrl( Request $request )
    {

        switch( $request->getUrl() ) {

            case '/rest/users':
                if ( $request->getMethod() == Request::POST ) {
                    $credentials = $this->getCredentials( $request );
                    $command = new Command\CreateUser( $credentials['email'], $credentials['password'],
                        $credentials['firstName'], $credentials['lastName'] );
                    return new CommandHandler\CreateUser( $command, new UserRepository() );
                }
                break;
            case '/rest/authenticate':
                if ( $request->getMethod() == Request::POST ) {
                    $credentials = $this->getCredentials( $request );
                    $command = new Authenticate( $credentials['email'], $credentials['password'] );
                    return new CommandHandler\Authenticate( $command, new UserRepository() );
                }
                break;

        }

        return null;
    }


    private function getCredentials( Request $request )
    {
        $raw = json_decode( $request->getBody() );
        if ( !( $raw instanceof \stdClass ) ) {
            throw new InvalidArgumentException( 'body decodes not to an stdClass object' );
        }
        $result = [];

        $result['email'] = Email::fromString( $raw->email );
        $result['password'] = Password::fromString( $raw->password );
        $result['firstName'] = isset($raw->firstName) ? (string)$raw->firstName : '';
        $result['lastName'] = isset($raw->lastName) ? (string)$raw->lastName : '';

        return $result;
    }
}