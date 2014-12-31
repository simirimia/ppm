
var ppmControllers = angular.module('ppmControllers', []);

ppmControllers.controller('PpmCtrl', function($scope) {

});

/**
 * Thumbnail view which shows thumbnails for all pictures
 */
ppmControllers.controller('ThumbnailListCtrl', function ($scope, $http, $modal, $location) {


    $scope.loadThumbnails = function( $scope ) {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function(data) {
            $scope.thumbnails = data;
        });
    };


    // init calls
    ppmControllers.ThumbnailListHelper_init( $scope, $modal, $location );
    $scope.loadThumbnails( $scope );
});

/**
 * Thumbnail view which shows thumbnails for all pictures with a given tag
 */
ppmControllers.controller('ThumbnailsListByTagCtrl', function ($scope, $http, $modal, $routeParams, $location) {

    $scope.loadThumbnails = function( $scope ) {
        $http.get('/rest/tags/' + $routeParams.tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function(data) {
            $scope.thumbnails = data;
        });
    };

    $scope.selectedTag = $routeParams.tag;

    // init calls
    ppmControllers.ThumbnailListHelper_init( $scope, $modal, $location );


    $scope.loadThumbnails( $scope );


});

/**
 * Base stuff done for all controller which produce a thumbnail list as output
 */
ppmControllers.ThumbnailListHelper_init = function( $scope, $modal, $location ) {

    $scope.thumbnailsCurrentPage = 1;
    $scope.thumbnailsPageSize = 20;


    $scope.thumbnailsPageChanged = function() {
        console.log( 'New thumbnail page: ' + $scope.thumbnailsCurrentPage );
        $scope.loadThumbnails( $scope );
    };

    $scope.setPage = function( pageNumber ) {
        console.log( 'setting page to: ' + pageNumber );
        $scope.currentPage = pageNumber;
    };

    $scope.showThumbnailsForTag = function( tag ) {
        $location.path( 'pictures/tags/' + tag );
    };

    $scope.showDetail = function( pictureId ) {
        console.log( 'Show detail view for pictureId:' + pictureId );
        $location.path( '/pictures/' + pictureId );
    };

    $scope.previewSize = 800;
    $scope.showThumbnailModal = function( pictureId ) {
        var modalInstance = $modal.open({
            templateUrl: 'thumbnailPreview.html',
            controller: 'ThumbnailPreviewInstanceCtrl',
            size: 'lg',
            resolve: {
                pictureId: function() {
                    return pictureId;
                },
                size: function() {
                    return $scope.previewSize;
                }
            },
            backdrop: true
        });

        modalInstance.result.then(function ( ret ) {
            $scope.previewSize = ret[1];
            $scope.showThumbnailModal( ret[0] );
        }, function () {
            //$scope.previewSize = 800;
        });

    };


};



// controller for overlay with bigger preview within the thumbnail list view
ppmControllers.controller('ThumbnailPreviewInstanceCtrl', function ($scope, $modalInstance, $window, pictureId, size) {
    $scope.pictureId = pictureId;
    $scope.size = size;

    $scope.showLarge = function() {
        $modalInstance.close( [ pictureId, 1400 ] );
    };

    $scope.showSmall = function() {
        $modalInstance.close( [ pictureId, 800 ] );
    };

    $scope.close = function() {
        $modalInstance.dismiss('close');
    };

    $scope.showOriginal = function() {
        $window.open('/rest/pictures/' + pictureId + '/original');
    }

});

// controller for the picture detail view
ppmControllers.controller('PictureDetailCtrl', function($scope, $routeParams, $http) {

         $scope.pictureId = $routeParams.pictureId;

         $scope.loadExif = function(  pictureId) {
             $http.get('/rest/pictures/' + pictureId + '/exif').success(function(data) {
                 $scope.exif = data;
             });
         };

         $scope.loadExif( $routeParams.pictureId );
});

/*
ppmControllers.controller('PictureDetailCtrl', ['$scope', '$routeParams', '$http',
    function($scope, $routeParams, $http) {

        $scope.pictureId = $routeParams.pictureId;

        $scope.loadExif = function() {
            $http.get('/rest/pictures/' + pictureId + '/exif').success(function(data) {
                $scope.exif = data;
            });
        };

        $scope.loadExif();
    }]);
    */