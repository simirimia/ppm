var ppmApp = angular.module('ppmApp', [
    'ui.bootstrap',
    'ngRoute',
    'ngDraggable',
    'infinite-scroll',
    'ppmControllers',
    'ppmThumbnailListControllers',
    'ppmPictureDetailControllers',
    'ppmTagControllers'
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
            when('/pictures/:pictureId/alternatives',{ //when('/alternatives/:pictureId',{
                templateUrl: 'partials/picture-detail-alternatives.html',
                controller: 'PictureAlternativeController'
            }).

            // tag specific routes
            when('/tags', {
               templateUrl: 'partials/tag-list.html',
                controller: 'TagController'
            }).

            // the default route
            otherwise({
                //redirectTo: '/pictures'
                templateUrl: 'partials/welcome.html',
                controller: 'WelcomeController'
            });
    }]);