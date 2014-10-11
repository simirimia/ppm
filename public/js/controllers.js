var ppmApp = angular.module('ppmApp', []);

ppmApp.controller('PpmCtrl', function ($scope, $http) {

    $http.get('/rest/pictures/thumbnails/small').success(function(data) {
        $scope.thumbnails = data;
    });

});