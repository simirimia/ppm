var ppmApp = angular.module('ppmApp', ['ui.bootstrap']);

ppmApp.controller('PpmCtrl', function ($scope, $http, $modal) {

    $scope.thumbnailsCurrentPage = 1;
    $scope.thumbnailsPageSize = 20;


    $scope.thumbnailsPageChanged = function() {
        console.log( 'New thumbnail page: ' + $scope.thumbnailsCurrentPage );
        $scope.loadThumbnails( $scope );
    }

    $scope.setPage = function( pageNumber ) {
        console.log( 'setting page to: ' + pageNumber );
        $scope.currentPage = pageNumber;
    }

    $scope.loadThumbnails = function( $scope ) {
        $http.get('/rest/pictures/thumbnails/small?page=' + $scope.thumbnailsCurrentPage + '&pageSize=' + $scope.thumbnailsPageSize).success(function(data) {
            $scope.thumbnails = data;
        });
    }


    $scope.showThumbnailModal = function( pictureId ) {
        var modalInstance = $modal.open({
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',
            resolve: {
                pictureId: function() {
                    return pictureId;
                }
            },
            backdrop: true
        });
    }


    // init calls
    $scope.loadThumbnails( $scope );
});


ppmApp.controller('ModalInstanceCtrl', function ($scope, $modalInstance, pictureId) {
    $scope.pictureId = pictureId;

    $scope.close = function() {
        $modalInstance.dismiss('close');
    }
});