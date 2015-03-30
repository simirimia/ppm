var ppmAdminControllers = angular.module('ppmAdminControllers', []);

ppmAdminControllers.controller('AdminController', function ($scope, $routeParams, $http, $location) {

    $scope.folderToScan = '';

    $scope.alertMessage = 'Some default text';
    $scope.alertTypeClass = 'alert-info';
    $scope.showAlert = false;

    $scope.disableAlert = function () {
        $scope.showAlert = false;
    };

    $scope.scanFolder = function() {
        console.log( 'Scanning folder: ' + $scope.folderToScan );
        $http.post( '/rest/pictures/scan', $scope.folderToScan ).success( function(data) {
            console.log( 'scan success', data );
        }).error( function(data) {
            console.log( 'scan error', data );
        } )
    };

    $scope.extractExif = function() {
        $http.post( '/rest/pictures/extract-exif', '' ).success( function(data) {
            console.log( 'exif success', data );
            $scope.showAlert = true;
            $scope.alertTypeClass = 'alert-success';
            $scope.alertMessage = 'Exif extracted: ' + JSON.stringify(data);
        }).error( function(data) {
            console.log( 'exif error', data );
            $scope.showAlert = true;
            $scope.alertTypeClass = 'alert-danger';
            $scope.alertMessage = 'Exif extracted: ' + JSON.stringify(data);
        } )
    };

    $scope.createThumbnails = function() {
        $http.post('/rest/pictures/thumbnails/create', '').success( function(data) {
            console.log( 'thumbnail success', data );
            $scope.showAlert = true;
            if ( data.moreAvailable == true ) {
                $scope.alertTypeClass = 'alert-info';
                $scope.alertMessage = 'More Pictures without thumbnails are available. Restart job! Check console for details';
            } else {
                $scope.alertTypeClass = 'alert-success';
                $scope.alertMessage = 'Thumbnails created. Check console for details ';
            }
        }).error( function(data) {
            console.log( 'thumbnail error', data );
            $scope.showAlert = true;
            $scope.alertTypeClass = 'alert-danger';
            $scope.alertMessage = data.message;
        } )
    }
});
