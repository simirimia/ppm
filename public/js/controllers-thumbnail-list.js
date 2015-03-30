var ppmThumbnailListControllers = angular.module('ppmThumbnailListControllers', []);


/**
 * Thumbnail view which shows thumbnails for all pictures
 */
ppmThumbnailListControllers.controller('ThumbnailListCtrl', function ($scope, $http, $modal, $location, $window) {

    $scope.additionalPicturesAvailable = true;

    $scope.loadThumbnails = function ($scope) {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {
            $scope.thumbnails = data;
        });
    };

    $scope.appendMoreThumbnails = function() {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {

            if ( jQuery.isEmptyObject( data ) ) {
                $scope.additionalPicturesAvailable = false;
            } else {
                jQuery.extend( $scope.thumbnails, data );
                $scope.additionalPicturesAvailable = true;
            }

        });
    }


    // init calls
    ppmThumbnailListControllers.ThumbnailListHelper_init($scope, $modal, $location, $http, $window);
    $scope.loadThumbnails($scope);
});

/**
 * Thumbnail view which shows thumbnails for all pictures with a given tag
 */
ppmThumbnailListControllers.controller('ThumbnailsListByTagCtrl', function ($scope, $http, $modal, $routeParams, $location, $window) {

    $scope.additionalPicturesAvailable = true;

    $scope.loadThumbnails = function ($scope) {
        $http.get('/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {
            $scope.thumbnails = data;
        });
    };

    $scope.appendMoreThumbnails = function () {
        $http.get('/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function (data) {

            if ( jQuery.isEmptyObject( data ) ) {
                $scope.additionalPicturesAvailable = false;
            } else {
                jQuery.extend( $scope.thumbnails, data );
                $scope.additionalPicturesAvailable = true;
            }
        });
    };

    $scope.selectedTag = $routeParams.tag;

    // init calls
    ppmThumbnailListControllers.ThumbnailListHelper_init($scope, $modal, $location, $http, $window);


    $scope.loadThumbnails($scope);


});

/**
 * Base stuff done for all controller which produce a thumbnail list as output
 */
ppmThumbnailListControllers.ThumbnailListHelper_init = function ($scope, $modal, $location, $http, $window) {

    $scope.thumbnailsCurrentPage = 1;
    $scope.thumbnailsPageSize = 20;
    $scope.mainPicture = { id: 0, href: '' };
    $scope.showTags = true;
    $scope.showMarker = true;

    $scope.alertMessage = 'Some default text';
    $scope.alertTypeClass = 'alert-info';
    $scope.showAlert = false;

    $scope.showEditPictureStuff = true;
    $scope.showAlternativeHandlingStuff = true;

    $scope.disableAlert = function () {
        $scope.showAlert = false;
    };

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
        //$location.path('/pictures/' + pictureId);
        $window.open('http://localhost/#/pictures/' + pictureId);
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

    $scope.deleteThumbnails = function( pictureId ) {
        console.log( 'deleting thumbnails for picture ' + pictureId );
        $http.delete( '/rest/pictures/' + pictureId + '/thumbnails').success( function(data) {
            console.log( 'thumbnail success deletion returned: ', data );
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are deleted - reload page necessary :-(';
            $scope.thumbnails[pictureId].href = null;
        }).error( function(data) {
            console.log( 'thumbnail error deletion returned: ', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.createThumbnails = function( pictureId ) {
        console.log( 'creating thumbnails for picture ' + pictureId );
        $http.post( '/rest/pictures/' + pictureId + '/thumbnails', null).success( function(data) {
            console.log( 'thumbnail success creation returned: ', data );
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are created - reload page necessary :-(';
            $scope.thumbnails[pictureId].href = null;
        }).error( function(data) {
            console.log( 'thumbnail error creation returned: ', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.rotateThumbnails = function( pictureId, rotationType ) {
        console.log( 'rotating thumbs for picture ' + pictureId + ' in direction: ' + rotationType );
        $http.post( '/rest/pictures/' + pictureId + '/thumbnails/rotate', rotationType).success( function(data) {
            console.log('thumb rotate success', data);
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are rotated - reload page necessary :-(';
        }).error( function(data) {
            console.log( 'thumb rotate error', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.rotatateThumbnailsClockwise = function( pictureId ) {
        $scope.rotateThumbnails( pictureId, 'clockwise' );
    };
    $scope.rotatateThumbnailsCounterClockwise = function( pictureId ) {
        $scope.rotateThumbnails( pictureId, 'counterclockwise' );
    };

    $scope.onDragComplete=function(data,evt){
        console.log("drag success, data:", data);
    };

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
    };

    $scope.resetMainPicture = function() {
        console.log('reset main picture. Was:', $scope.mainPicture);
        $scope.mainPicture = { id: 0, href: '' };
    };

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

    $scope.myPagingFunction = function() {
        $scope.thumbnailsCurrentPage++;
        $scope.appendMoreThumbnails();
    };

};


// controller for overlay with bigger preview within the thumbnail list view
ppmThumbnailListControllers.controller('ThumbnailPreviewInstanceCtrl', function ($scope, $modalInstance, $window, pictureId, size) {
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
