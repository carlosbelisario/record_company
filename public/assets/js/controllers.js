/**
 *
 * controllers
 */

var albumController = angular.module('albumControllers', []);

albumController.controller('AlbumListCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.albums = {};

    $http.get(laroute.url('albums', []))
        .success(function(data) {
            $scope.albums = data.albums;
            console.log(data.albums[0].id)
        })
        .error(function(data) {
            console.log('Error: ' + data);
        });

}]);

albumController.controller('AlbumAddCtrl', ['$scope', '$http', function($scope, $http) {
    alert('yeah');
}]);

