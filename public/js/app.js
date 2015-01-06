var ppmApp = angular.module('ppmApp', [
    'ui.bootstrap',
    'ngRoute',
    'ngDraggable',
    'ppmControllers'
]);


ppmApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.

            // all routes which end up showing a list of thumbnails
            when('/pictures', {
                templateUrl: 'partials/thumbnail-list.html',
                controller: 'ThumbnailListCtrl'
            }).
            when('/pictures/tags/:tag', {
               templateUrl: 'partials/thumbnail-list.html',
                controller: 'ThumbnailsListByTagCtrl'
            }).

            // all routes which show data related to one specific picture
            when('/pictures/:pictureId', {
                templateUrl: 'partials/picture-detail.html',
                controller: 'PictureDetailCtrl'
            }).

            //'pictures/' + $scope.pictureId + '/alternatives'
            when('pictures/:pictureId/alternatives',{
                templateUrl: 'partials/picture-detail-alternatives.html',
                controller: 'PictureDetailCtrl'
            }).

            // the default route
            otherwise({
                //redirectTo: '/pictures'
                templateUrl: 'partials/welcome.html',
                controller: 'WelcomeController'
            });
    }]);