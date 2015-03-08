var ppmApp = angular.module('ppmApp', [
    'ui.bootstrap',
    'ngRoute',
    'ngDraggable',
    'infinite-scroll',
    'ppmControllers',
    'ppmThumbnailListControllers',
    'ppmPictureDetailControllers',
    'ppmTagControllers',
    'ppmUserControllers'
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

/*
angular.module('ppmApp').run(['$rootScope',function($rootScope){
    $rootScope.$on('$stateChangeStart',function(event, toState, toParams, fromState, fromParams){
        console.log('$stateChangeStart to '+toState.to+'- fired when the transition begins. toState,toParams : \n',toState, toParams);
    });
    $rootScope.$on('$stateChangeError',function(event, toState, toParams, fromState, fromParams, error){
        console.log('$stateChangeError - fired when an error occurs during transition.');
        console.log(arguments);
    });
    $rootScope.$on('$stateChangeSuccess',function(event, toState, toParams, fromState, fromParams){
        console.log('$stateChangeSuccess to '+toState.name+'- fired once the state transition is complete.');
    });
    $rootScope.$on('$viewContentLoaded',function(event){
        console.log('$viewContentLoaded - fired after dom rendered',event);
    });
    $rootScope.$on('$stateNotFound',function(event, unfoundState, fromState, fromParams){
        console.log('$stateNotFound '+unfoundState.to+'  - fired when a state cannot be found by its name.');
        console.log(unfoundState, fromState, fromParams);
    });
    $rootScope.$on('$routeChangeError', function(current, previous, rejection) {
        console.log("routeChangeError", currrent, previous, rejection);
    });

    $rootScope.$on('$routeChangeStart', function(next, current) {
        console.log("routeChangeStart");
        console.dir(next);
        console.dir(current);
    });

    $rootScope.$on('$routeChangeSuccess', function(current, previous) {
        console.log("routeChangeSuccess");
        console.dir(current);
        console.dir(previous);
    });

    $rootScope.$on('$routeUpdate', function(rootScope) {
        console.log("routeUpdate", rootScope);
    });
}]);
    */