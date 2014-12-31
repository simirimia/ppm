var ppmApp = angular.module('ppmApp', [
    'ui.bootstrap',
    'ngRoute',
    'ppmControllers'
]);


ppmApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/pictures', {
                templateUrl: 'partials/thumbnail-list.html',
                controller: 'ThumbnailListCtrl'
            }).
            when('/pictures/:pictureId', {
                templateUrl: 'partials/picture-detail.html',
                controller: 'PictureDetailCtrl'
            }).
            otherwise({
                redirectTo: '/pictures'
            });
    }]);