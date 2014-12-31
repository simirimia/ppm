
var ppmControllers = angular.module('ppmControllers', []);

ppmControllers.controller('PpmCtrl', function($scope) {

});

ppmControllers.controller('ThumbnailListCtrl', function ($scope, $http, $modal) {

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

    $scope.showThumbnailsForTag = function( tag ) {
        $http.get('/rest/tags/' + tag + '/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function(data) {
            $scope.thumbnails = data;
        });
    }


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
ppmControllers.controller('PictureDetailCtrl', ['$scope', '$routeParams',
     function($scope, $routeParams) {
         $scope.pictureId = $routeParams.pictureId;
}]);