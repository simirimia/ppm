var ppmThumbnailListControllers = angular.module( 'ppmThumbnailListControllers', [] );


/**
 * Thumbnail view which shows thumbnails for all pictures
 */
ppmThumbnailListControllers.controller( 'ThumbnailListCtrl', function ( $scope, $http, $location, $window ) {

    $scope.additionalPicturesAvailable = true;

    $scope.loadThumbnails = function ( $scope ) {
        $http.get( '/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize ).success( function ( data ) {
            $scope.thumbnails = data;
        } );
    };

    $scope.appendMoreThumbnails = function () {
        $http.get( '/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize ).success( function ( data ) {

            if ( jQuery.isEmptyObject( data ) ) {
                $scope.additionalPicturesAvailable = false;
            } else {
                jQuery.extend( $scope.thumbnails, data );
                $scope.additionalPicturesAvailable = true;
            }

        } );
    };


    // init calls
    ppmThumbnailListControllers.ThumbnailListHelper_init( $scope, $location, $http, $window );
    $scope.loadThumbnails( $scope );
} );

/**
 * Thumbnail view which shows thumbnails for all pictures with a given tag
 */
ppmThumbnailListControllers.controller( 'ThumbnailsListByTagCtrl', function ( $scope, $http, $routeParams, $location, $window ) {

    $scope.additionalPicturesAvailable = true;

    $scope.loadThumbnails = function ( $scope ) {
        $http.get( '/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize ).success( function ( data ) {
            $scope.thumbnails = data;
        } );
    };

    $scope.appendMoreThumbnails = function () {
        $http.get( '/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize ).success( function ( data ) {

            if ( jQuery.isEmptyObject( data ) ) {
                $scope.additionalPicturesAvailable = false;
            } else {
                jQuery.extend( $scope.thumbnails, data );
                $scope.additionalPicturesAvailable = true;
            }
        } );
    };

    $scope.selectedTag = $routeParams.tag;

    // init calls
    ppmThumbnailListControllers.ThumbnailListHelper_init( $scope, $location, $http, $window );


    $scope.loadThumbnails( $scope );


} );

/**
 * Base stuff done for all controller which produce a thumbnail list as output
 */
ppmThumbnailListControllers.ThumbnailListHelper_init = function ( $scope, $location, $http, $window ) {

    $scope.thumbnailsCurrentPage = 1;
    $scope.thumbnailsPageSize = 20;
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
        console.log( 'New thumbnail page: ' + $scope.thumbnailsCurrentPage );
        $scope.loadThumbnails( $scope );
    };

    $scope.setPage = function ( pageNumber ) {
        console.log( 'setting page to: ' + pageNumber );
        $scope.currentPage = pageNumber;
    };

    $scope.showThumbnailsForTag = function ( tag ) {
        $location.path( 'pictures/tags/' + tag );
    };

    $scope.showDetail = function ( pictureId ) {
        console.log( 'Show detail view for pictureId:' + pictureId );
        //$location.path('/pictures/' + pictureId);
        $window.open( '/#/pictures/' + pictureId );
    };

    $scope.addTag = function ( pictureId ) {
        var tag = $scope.thumbnails[pictureId].newTag;
        console.log( 'Adding tag ' + tag + ' to picture with ID ' + pictureId );
        $http.post( '/rest/pictures/' + pictureId + '/tags', tag ).success( function ( data ) {
            console.log( 'tag add success' );
            $http.get( '/rest/pictures/' + pictureId + '/tags' ).success( function ( data ) {
                $scope.thumbnails[pictureId].tags = data.tags;
            } )
        } ).error( function (data) {
            console.log( 'tag add error' );
        } ).finally( function(data) {
            console.log('finally....');
        } );
    };

    $scope.removeTag = function ( pictureId, tag ) {
        console.log( 'Removing tag ' + tag + ' to picture with ID ' + pictureId );
        $http.delete( '/rest/pictures/' + pictureId + '/tags/' + tag ).success( function ( data ) {
            console.log( 'Tag removal returned: ', data );
            $scope.thumbnails[pictureId].tags = data.tags;
        } );
    };

    $scope.hasTag = function ( tag, tags ) {
        var returnValue = false;
        tags.forEach( function ( e ) {
            if ( e == tag ) {
                returnValue = true;
            }
        } );
        return returnValue;
    };

    $scope.deleteThumbnails = function ( pictureId ) {
        console.log( 'deleting thumbnails for picture ' + pictureId );
        $http.delete( '/rest/pictures/' + pictureId + '/thumbnails' ).success( function ( data ) {
            console.log( 'thumbnail success deletion returned: ', data );
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are deleted - reload page necessary :-(';
            $scope.thumbnails[pictureId].href = null;
        } ).error( function ( data ) {
            console.log( 'thumbnail error deletion returned: ', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.createThumbnails = function ( pictureId ) {
        console.log( 'creating thumbnails for picture ' + pictureId );
        $http.post( '/rest/pictures/' + pictureId + '/thumbnails', null ).success( function ( data ) {
            console.log( 'thumbnail success creation returned: ', data );
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are created - reload page necessary :-(';
            $scope.thumbnails[pictureId].href = null;
        } ).error( function ( data ) {
            console.log( 'thumbnail error creation returned: ', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.rotateThumbnails = function ( pictureId, rotationType ) {
        console.log( 'rotating thumbs for picture ' + pictureId + ' in direction: ' + rotationType );
        var id = pictureId;
        $http.post( '/rest/pictures/' + pictureId + '/thumbnails/rotate', rotationType ).success( function ( data ) {
            console.log( 'thumb rotate success', data );
            $scope.thumbnails[id].href = $scope.thumbnails[id].href + '?' + Math.random();
            $scope.alertTypeClass = 'alert-success';
            $scope.showAlert = true;
            $scope.alertMessage = 'Thumbnails are rotated';
        } ).error( function ( data ) {
            console.log( 'thumb rotate error', data );
            $scope.alertTypeClass = 'alert-danger';
            $scope.showAlert = true;
            $scope.alertMessage = data.message;
        } )
    };

    $scope.rotatateThumbnailsClockwise = function ( pictureId ) {
        $scope.rotateThumbnails( pictureId, 'clockwise' );
    };
    $scope.rotatateThumbnailsCounterClockwise = function ( pictureId ) {
        $scope.rotateThumbnails( pictureId, 'counterclockwise' );
    };

    $scope.dndSession = sfDragNDropService.session;

    $scope.onThumbnailDrop = function ( pictureId, targettedItem, returnValue ) {
        console.log( 'item', pictureId );
        console.log( 'targetedItem', targettedItem );
        var id = pictureId;
        $http.post( 'rest/pictures/' + targettedItem.id + '/alternatives', pictureId ).success(
            function ( data ) {
                console.log( 'Adding alternative returned: ', data );
                $scope.alertTypeClass = 'alert-success';
                $scope.showAlert = true;
                $scope.alertMessage = 'Marked als alternative successful';
                $scope.thumbnails[id] = { href : 'nope', id: 0, tags: [] };
            }
        ).error( function(data) {
                console.log( 'Adding alternative returned: ', data );
                $scope.alertTypeClass = 'alert-danger';
                $scope.showAlert = true;
                $scope.alertMessage = 'Error: ' + data.message;
            } );
    };

    $scope.myPagingFunction = function () {
        $scope.thumbnailsCurrentPage++;
        $scope.appendMoreThumbnails();
    };

};



