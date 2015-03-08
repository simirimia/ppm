var ppmUserControllers = angular.module('ppmUserControllers', []);

ppmUserControllers.controller( 'UserController', function( $scope, $http, UserService ) {

    //$scope.user = UserService;

    $scope.authenticate = function( user ) {
        console.log( 'Authenticating...' );
        $http.post( '/rest/authenticate', user )
            .success( function( data ) {
                console.log( data, 'Authentication success' );
            } )
            .error( function( data ) {
                console.log( data, 'Authentication failed' );
            } )
    };

} );

ppmUserControllers.controller( 'UserRegisterController', function( $scope, $http ) {

    $scope.errors = [];



    $scope.register = function( user ) {

        $scope. errors = [];
        if ( user.password != user.retypePassword ) {
            console.log( 'Passwords not match' );
            $scope.errors.push( 'Passwords do not match' );
        }
        if ( user.email == '' || user.email == null ) {
            console.log( 'E-mail is invalid' );
             $scope.errors.push( 'E-mail is invalid' );
        }
        if ( $scope.errors.length > 0 ) {
            console.log( 'There were errors. Form is not sent' );
            return;
        }
        $http.post( '/rest/users', user)
            .success( function( data ) {
                console.log( data, 'create user returned success' );
        })
            .error( function( data ) {
                console.log( data, 'create user returned error' )
        } )
    }

} );