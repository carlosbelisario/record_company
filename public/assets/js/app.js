var myApp = angular.module('myApp', ['ngRoute', 'ngMessages', 'ui.bootstrap', 'ngResource']
).config(function($interpolateProvider, $httpProvider, $routeProvider) {
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';



        //routing
        $routeProvider.
            when('/', {
                templateUrl: '../public/app/partials/album/list.html',
                controller: 'AlbumListCtrl'
            }).
            when('/album', {
                templateUrl: '../public/app/partials/album/list.html',
                controller: 'AlbumListCtrl'
            }).
            when('/album/add', {
                templateUrl: '../public/app/partials/album/add.html',
                controller: 'AlbumAddCtrl'
            }).when('/album/edit/:id', {
                templateUrl: '../public/app/partials/album/edit.html',
                controller: 'AlbumEditCtrl'
            }).when('/album/detail/:id', {
                templateUrl: '../public/app/partials/album/details.html',
                controller: 'AlbumEditCtrl'
            }).otherwise({
                redirectTo: '/album'
            });

    });

myApp.factory('listAlbumsFactory', function($resource) {
    return $resource(laroute.url('albums', []))
});

myApp.factory('listArtistsFactory', function($resource) {
    return $resource(laroute.url('artist', []))
});

myApp.controller('AlbumListCtrl', ['$scope', '$rootScope', 'flash', 'listAlbumsFactory',
    function($scope, $rootScope, flash, listAlbumsFactory) {
        $scope.albums = listAlbumsFactory.query();
        $rootScope.flash = flash;

        $scope.itemsPerPage = 10
        $scope.currentPage = 1;
        $scope.pageCount = function () {
            return Math.ceil($scope.albums.length / $scope.itemsPerPage);
        };
        $scope.albums.$promise.then(function () {
            $scope.totalItems = $scope.albums.length;
            $scope.$watch('currentPage + itemsPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.itemsPerPage),
                    end = begin + $scope.itemsPerPage;
                $scope.filteredAlbums = $scope.albums.slice(begin, end);
            });
        });

}]);

myApp.controller('AlbumDetailCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
    $http.get(laroute.url('albums/detail', [$routeParams.id])).success(function(data) {
        $scope.album = data;
    });
}]);

myApp.controller('AlbumEditCtrl', ['$scope', '$rootScope', '$http', '$routeParams', '$location', 'flash',
    'listArtistsFactory',
    function($scope, $rootScope, $http, $routeParams, $location, flash, listArtistsFactory) {
        $rootScope.flash = flash;
        $scope.artistsList = listArtistsFactory.query();
        $http.get(laroute.url('albums/detail', [$routeParams.id])).success(function(data) {
            $scope.album = data;
            $scope.album.author = [];
            for(var i = 0; i < data.artist.length; i++) {
                $scope.album.author[i] = data.artist[i].id;
            }
        });

        $scope.edit = function(album) {
            $http.put(
                laroute.url('albums/edit', [$routeParams.id]),
                album
            ).success(function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $scope.flash.set({type:'success', 'message':'Album editado correctamente'});
                        $location.path('/album');
                    }
                }).error(function(error) {
                    console.log(error);
                });
        }

        //add multiple artist
        $scope.artists = [{'id':1}];

        $scope.addNewArtist = function() {
            var newItemNo = $scope.artists.length+1;
            $scope.artists.push({'id':'choice'+newItemNo});
        };

        $scope.removeArtist = function() {
            var lastItem = $scope.artists.length-1;
            $scope.artists.splice(lastItem);
        };

        //datepicker
        $scope.open = function($event) {
            $scope.status.opened = true;
        };
        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.status = {
            opened: false
        };

        $scope.getDayClass = function(date, mode) {
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0,0,0,0);

                for (var i=0;i<$scope.events.length;i++){
                    var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }

            return '';
        };

    }
]);

myApp.controller('AlbumAddCtrl', ['$scope', '$rootScope', '$http', '$location', 'flash', 'listArtistsFactory',
    function($scope, $rootScope, $http, $location, flash, listArtistsFactory) {
    $rootScope.flash = flash;
    $scope.artistsList = listArtistsFactory.query();

    $scope.add = function(album) {
        $http.post(
            laroute.url('albums/create', []),
            album
        ).success(function(data) {
            console.log(data);
            if (data.status == 'success') {
                $scope.flash.set({type:'success', 'message':'Album agregado correctamente'});
                $location.path('/album');
            }
        }).error(function(error) {
           console.log(error);
        });
    }

    //add multiple artist
    $scope.artists = [{'id':1}];

    $scope.addNewArtist = function() {
        var newItemNo = $scope.artists.length+1;
        $scope.artists.push({'id':'choice'+newItemNo});
    };

    $scope.removeArtist = function() {
        var lastItem = $scope.artists.length-1;
        $scope.artists.splice(lastItem);
    };

    //datepicker
    $scope.open = function($event) {
        $scope.status.opened = true;
    };
    $scope.dateOptions = {
        formatYear: 'yy',
        startingDay: 1
    };

    $scope.status = {
        opened: false
    };

    $scope.getDayClass = function(date, mode) {
        if (mode === 'day') {
            var dayToCheck = new Date(date).setHours(0,0,0,0);

            for (var i=0;i<$scope.events.length;i++){
                var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                if (dayToCheck === currentDay) {
                    return $scope.events[i].status;
                }
            }
        }

        return '';
    };
}]);

//factories
myApp.factory("flash", function($rootScope) {
    var queue = [], currentMessage = '';

    $rootScope.$on('$routeChangeSuccess', function() {
        if (queue.length > 0)
            currentMessage = queue.shift();
        else
            currentMessage = '';
    });

    return {
        set: function(message) {
            queue.push(message);
        },
        get: function(message) {
            return currentMessage;
        }
    };
});
