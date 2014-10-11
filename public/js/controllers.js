var ppmApp = angular.module('ppmApp', []);

ppmApp.controller('PpmCtrl', function ($scope, $http) {

    $http.get('data.php').success(function(data) {
        $scope.phones = data;
    });

});