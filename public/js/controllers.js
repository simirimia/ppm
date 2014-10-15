var ppmApp = angular.module('ppmApp', ['ui.bootstrap']);

ppmApp.controller('PpmCtrl', function ($scope, $http) {

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


    // init calls

    $scope.loadThumbnails( $scope );
});

