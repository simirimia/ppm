var ppmPictureDetailControllers = angular.module('ppmPictureDetailControllers', []);


// controller for the picture detail view
ppmPictureDetailControllers.controller('PictureDetailCtrl', function ($scope, $routeParams, $http, $location) {

    $scope.pictureId = $routeParams.pictureId;

    $scope.newTag = "Enter new tag here";

    $scope.exifIsCollapsed = true;

    $scope.loadDetails = function (pictureId) {
        $http.get('/rest/pictures/' + pictureId + '/details').success(function (data) {
            $scope.details = data;
        });
    };

    $scope.showThumbnailsForTag = function (tag) {
        $location.path('pictures/tags/' + tag);
    };

    $scope.addTag = function() {
        console.log( 'New tag is: ' + $scope.newTag );
        $http.post( '/rest/pictures/' + $scope.pictureId + '/tags', $scope.newTag).success( function(data) {
            console.log( 'Tag update returned: ' + data );
            $scope.details.tags = data.tags;
        } );
    }

    // TODO: how to get event and keycode???
    $scope.newTagKeyPressed = function( foo ) {
        console.log( foo );
    }

    $scope.showAlternatives = function() {
        $location.path('/pictures/' + $scope.pictureId + '/alternatives');
    }

    $scope.loadDetails($routeParams.pictureId);
});

