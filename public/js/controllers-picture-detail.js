var ppmPictureDetailControllers = angular.module('ppmPictureDetailControllers', []);


// controller for the picture detail view
ppmPictureDetailControllers.controller('PictureDetailCtrl', function ($scope, $routeParams, $http, $location) {

    $scope.newTag = "Enter new tag here";

    $scope.addTag = function() {
        console.log( 'New tag is: ' + $scope.newTag );
        $http.post( '/rest/pictures/' + $scope.pictureId + '/tags', $scope.newTag).success( function(data) {
            console.log( 'Tag update returned: ' + data );
            $http.get('/rest/pictures/' + $scope.pictureId + '/tags').success( function(data) {
                $scope.details.tags = data.tags;
            } )
        } );
    }

    // TODO: how to get event and keycode???
    $scope.newTagKeyPressed = function( foo ) {
        console.log( foo );
    }

    $scope.showAlternatives = function() {
        $location.path('/pictures/' + $scope.pictureId + '/alternatives');
    }

    ppmPictureDetailControllers.PictureDetailCtrlHelper_init( $scope, $routeParams, $http, $location );

});

ppmPictureDetailControllers.controller( 'PictureAlternativeController', function( $scope, $routeParams, $http, $location )
{
    $scope.showAlert = true;
    $scope.alertMessage = "Loading Data ...";

    ppmPictureDetailControllers.PictureDetailCtrlHelper_init( $scope, $routeParams, $http, $location );

    $http.get( '/rest/pictures/' + $scope.pictureId + '/alternatives').success( function(data) {
        $scope.alternatives = data;
    } );

    $scope.showAlert = false;
});


ppmPictureDetailControllers.PictureDetailCtrlHelper_init = function ($scope, $routeParams, $http, $location) {

    $scope.pictureId = $routeParams.pictureId;

    $scope.exifIsCollapsed = true;

    $scope.loadDetails = function (pictureId) {
        $http.get('/rest/pictures/' + pictureId + '/details').success(function (data) {
            $scope.details = data;
        });
    };

    $scope.showThumbnailsForTag = function (tag) {
        $location.path('pictures/tags/' + tag);
    };

    $scope.showDetail = function (pictureId) {
        $location.path('/pictures/' + pictureId);
    };

    $scope.loadDetails($routeParams.pictureId);
};

