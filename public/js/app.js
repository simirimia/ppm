var ppmApp = angular.module('ppmApp', [
    'ngRoute',
    'ngDraggable',
    'infinite-scroll',
    'ngLoadingSpinner',
    'ppmControllers',
    'ppmThumbnailListControllers',
    'ppmPictureDetailControllers',
    'ppmTagControllers',
    'ppmUserControllers',
    'ppmAdminControllers'
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

            // admin / management routes
            when('/admin', {
                templateUrl : 'partials/admin.html',
                controller : 'AdminController'
            }).

            // user management
            when('/login', {
                templateUrl : 'partials/user-login.html',
                controller: 'UserController'
            }).
            when('/register', {
                templateUrl : 'partials/user-register.html',
                controller: 'UserRegisterController'
            }).

            // the default route
            otherwise({
                //redirectTo: '/pictures'
                templateUrl: 'partials/welcome.html',
                controller: 'WelcomeController'
            });
    }]);

ppmApp.factory( 'UserService', function () {

    var currentUser = {
        isLoggedIn: false,
        email: 'anonymous',
        password: null,
        retypePassword: null,
        firstName: '',
        lastName: '',
        role: 'anon'
    };

    return {
        login: function () {

        },
        logout: function() {

        },
        getCurrentUser: function() {
            return currentUser;
        }
    };
} );
