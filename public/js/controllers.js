var ppmApp = angular.module('ppmApp', ['ui.bootstrap']);

ppmApp.controller('PpmCtrl', function ($scope, $http, $modal) {

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

    $scope.loadThumbnails = function( $scope ) {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function(data) {
            $scope.thumbnails = data;
        });
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


    // init calls
    $scope.loadThumbnails( $scope );
});


ppmApp.controller('ThumbnailPreviewInstanceCtrl', function ($scope, $modalInstance, pictureId, size) {
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


});