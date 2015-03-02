var ppmUserControllers = angular.module('ppmUserControllers', []);

ppmUserControllers.controller( 'UserController', function( $scope, $http, UserService ) {

    $scope.user = UserService;


} );