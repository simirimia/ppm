var ppmTagControllers = angular.module('ppmTagControllers', []);

ppmTagControllers.controller( 'TagController', function( $scope, $http ) {

    $http.get( '/rest/tags').success( function( data ) {
        $scope.tags = data;
    } );

} );
