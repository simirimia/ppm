var ppmControllers = angular.module('ppmControllers', []);

ppmControllers.controller('PpmCtrl', function ($scope) {

});

/**
 * Thumbnail view which shows thumbnails for all pictures
 */
ppmControllers.controller('ThumbnailListCtrl', function ($scope, $http, $modal, $location) {


    $scope.loadThumbnails = function ($scope) {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {
            $scope.thumbnails = data;
        });
    };


    // init calls
    ppmControllers.ThumbnailListHelper_init($scope, $modal, $location, $http);
    $scope.loadThumbnails($scope);
});

/**
 * Thumbnail view which shows thumbnails for all pictures with a given tag
 */
ppmControllers.controller('ThumbnailsListByTagCtrl', function ($scope, $http, $modal, $routeParams, $location) {

    $scope.loadThumbnails = function ($scope) {
        $http.get('/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {
            $scope.thumbnails = data;
        });
    };

    $scope.selectedTag = $routeParams.tag;

    // init calls
    ppmControllers.ThumbnailListHelper_init($scope, $modal, $location, $http);


    $scope.loadThumbnails($scope);


});

/**
 * Base stuff done for all controller which produce a thumbnail list as output
 */
ppmControllers.ThumbnailListHelper_init = function ($scope, $modal, $location, $http) {

    $scope.thumbnailsCurrentPage = 1;
    $scope.thumbnailsPageSize = 20;
    $scope.mainPicture = { id: 0, href: '' };

    $scope.thumbnailsPageChanged = function () {
        console.log('New thumbnail page: ' + $scope.thumbnailsCurrentPage);
        $scope.loadThumbnails($scope);
    };

    $scope.setPage = function (pageNumber) {
        console.log('setting page to: ' + pageNumber);
        $scope.currentPage = pageNumber;
    };

    $scope.showThumbnailsForTag = function (tag) {
        $location.path('pictures/tags/' + tag);
    };

    $scope.showDetail = function (pictureId) {
        console.log('Show detail view for pictureId:' + pictureId);
        $location.path('/pictures/' + pictureId);
    };

    $scope.addTag = function ( pictureId, tag ) {
        console.log( 'Adding tag ' + tag + ' to picture with ID ' + pictureId );
        $http.post( '/rest/pictures/' + pictureId + '/tags', tag).success( function(data) {
            console.log( 'Tag update returned: ' + data );
            $scope.thumbnails[pictureId].tags = data.tags;
        } );
    };

    $scope.removeTag = function ( pictureId, tag ) {
        console.log( 'Removing tag ' + tag + ' to picture with ID ' + pictureId );
        $http.delete( '/rest/pictures/' + pictureId + '/tags/' + tag).success( function(data) {
            console.log( 'Tag removal returned: ', data );
            $scope.thumbnails[pictureId].tags = data.tags;
        } );
    };

    $scope.hasTag = function( tag, tags ) {
        var returnValue = false;
        tags.forEach( function( e ) {
            if ( e == tag ) {
                returnValue = true;
            }
        } );
        return returnValue;
    };

    $scope.onDragComplete=function(data,evt){
        console.log("drag success, data:", data);
    }
    $scope.onDropComplete=function( pictureId ,evt ){
        console.log("drop success, source data", pictureId);
        if ( $scope.mainPicture.id == 0 ) {
            console.log('setting new main picture');
            $scope.mainPicture = $scope.thumbnails[pictureId];
        } else {
            console.log( 'Marking as Alternative' );
            $http.post( 'rest/pictures/' + $scope.mainPicture.id + '/alternatives', pictureId).success(
                function(data) {
                    console.log( 'Adding alternative returnded: ', data );
                }
            );
        }
    }
    $scope.resetMainPicture = function() {
        console.log('reset main picture. Was:', $scope.mainPicture);
        $scope.mainPicture = { id: 0, href: '' };
    }



    $scope.previewSize = 800;
    $scope.showThumbnailModal = function (pictureId) {
        var modalInstance = $modal.open({
            templateUrl: 'thumbnailPreview.html',
            controller: 'ThumbnailPreviewInstanceCtrl',
            size: 'lg',
            resolve: {
                pictureId: function () {
                    return pictureId;
                },
                size: function () {
                    return $scope.previewSize;
                }
            },
            backdrop: true
        });

        modalInstance.result.then(function (ret) {
            $scope.previewSize = ret[1];
            $scope.showThumbnailModal(ret[0]);
        }, function () {
            //$scope.previewSize = 800;
        });

    };

};


// controller for overlay with bigger preview within the thumbnail list view
ppmControllers.controller('ThumbnailPreviewInstanceCtrl', function ($scope, $modalInstance, $window, pictureId, size) {
    $scope.pictureId = pictureId;
    $scope.size = size;

    $scope.showLarge = function () {
        $modalInstance.close([ pictureId, 1400 ]);
    };

    $scope.showSmall = function () {
        $modalInstance.close([ pictureId, 800 ]);
    };

    $scope.close = function () {
        $modalInstance.dismiss('close');
    };

    $scope.showOriginal = function () {
        $window.open('/rest/pictures/' + pictureId + '/original');
    }

});

// controller for the picture detail view
ppmControllers.controller('PictureDetailCtrl', function ($scope, $routeParams, $http, $location) {

    $scope.pictureId = $routeParams.pictureId;

    $scope.newTag = "Enter new tag here";

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
        console.log('Routing to: ' + 'pictures/' + $scope.pictureId + '/alternatives');
        $location.path('pictures/' + $scope.pictureId + '/alternatives');
    }

    $scope.loadDetails($routeParams.pictureId);
});


// the welcome controller
ppmControllers.controller( 'WelcomeController', function() {

} )