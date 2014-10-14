var ppmApp = angular.module('ppmApp', ['ui.bootstrap']);

ppmApp.controller('PpmCtrl', function ($scope, $http) {

    $http.get('/rest/pictures/thumbnails/small').success(function(data) {
        $scope.thumbnails = data;
    });

});

ppmApp.controller('PaginationDemoCtrl', function ($scope) {
    $scope.totalItems = 64;
    $scope.currentPage = 4;

    $scope.setPage = function (pageNo) {
        $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function() {
        console.log('Page changed to: ' + $scope.currentPage);
    };

    $scope.maxSize = 5;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;
});