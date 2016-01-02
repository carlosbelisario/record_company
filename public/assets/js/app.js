var myApp = angular.module('myApp', ['ngRoute', 'ngMessages', 'ui.bootstrap', 'ngResource']
).config(function($interpolateProvider, $httpProvider, $routeProvider) {
        $interpolateProvider.startSymbol('[[').endSymbol(']]');
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';



        //routing
        $routeProvider.
            when('/album', {
                templateUrl: '../app/partials/album/list.html',
                controller: 'AlbumListCtrl'
            }).
            when('/album/add', {
                templateUrl: '../app/partials/album/add.html',
                controller: 'AlbumAddCtrl'
            }).when('/album/edit/:id', {
                templateUrl: '../app/partials/album/edit.html',
                controller: 'AlbumEditCtrl'
            }).when('/album/detail/:id', {
                templateUrl: '../app/partials/album/details.html',
                controller: 'AlbumEditCtrl'
            }).when('/artistas', {
                templateUrl: '../app/partials/artist/list.html',
                controller: 'ArtistListCtrl'
            }).when('/artistas/add', {
                templateUrl: '../app/partials/artist/add.html',
                controller: 'ArtistAddCtrl'
            }).when('/artist/edit/:id', {
                templateUrl: '../app/partials/artist/edit.html',
                controller: 'ArtistEditCtrl'
            }).when('/artist/detail/:id', {
                templateUrl: '../app/partials/artist/details.html',
                controller: 'ArtistDetailCtrl'
            }).otherwise({
                redirectTo: '/album'
            });
    });

myApp.factory('listAlbumsFactory', function($resource) {
    return $resource(laroute.url('albums/list', []))
});

myApp.factory('listArtistsFactory', function($resource) {
    return $resource(laroute.url('artists/list', []))
});

myApp.factory('listRolesFactory', function($resource) {
    return $resource(laroute.url('roles/list', []))
});

myApp.controller('AlbumListCtrl', ['$scope', '$rootScope', '$uibModal', 'flash', 'listAlbumsFactory',
    function($scope, $rootScope, $uibModal, flash, listAlbumsFactory) {
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

        //modal
        $scope.open = function (a) {
            $scope.a = a;
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'myModalContent.html',
                controller: 'ModalAlbumInstanceCtrl',
                size: 'sm',
                resolve: {
                    album: function () {
                        return $scope.a;
                    }
                }
            });
        }

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
        $scope.artists = [];
            $http.get(laroute.url('albums/detail', [$routeParams.id])).success(function(data) {
            $scope.album = data;
            $scope.album.author = [];
            for(var i = 0; i < data.artist.length; i++) {
                $scope.album.author[i] = data.artist[i].id;
                $scope.artists.push({id: i});
            }
        });

        $scope.allowDelete = $scope.artists.length > 1 ? true : false;

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

        $scope.addNewArtist = function() {
            var newItemNo = $scope.artists.length+1;
            $scope.artists.push({'id':'choice'+newItemNo});
            $scope.allowDelete = true;
        };

        $scope.removeArtist = function() {
            var lastItem = $scope.artists.length-1;
            $scope.artists.splice(lastItem);
            if (lastItem == 1) {
                $scope.allowDelete = false;
            }
            $http.get(laroute.url('album/artist/delete', [$routeParams.id, lastItem])).success(function(data) {

            });
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
    $scope.album = {}
    $scope.allowDelete = false;
    $rootScope.flash = flash;
    $scope.artistsList = listArtistsFactory.query();

    $scope.add = function(album) {
        console.log(album);
        $http.post(
            laroute.url('albums/create', []),
            album
        ).success(function(data) {
            console.log(data);
            if (data.status == 'success') {
                $scope.flash.set({type:'success', 'message':'Album agregado correctamente'});
                $location.path('/album');
            } else if (data.status == 'validation_error') {
                $scope.error = data.messages;
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
        $scope.allowDelete = true;
    };

    $scope.removeArtist = function() {
        var lastItem = $scope.artists.length-1;
        console.log(lastItem);
        if (lastItem == 1) {
            $scope.allowDelete = false;
        }
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

//artist controller
myApp.controller('ArtistListCtrl', ['$scope', '$rootScope', '$uibModal', 'flash', 'listArtistsFactory',
    function($scope, $rootScope, $uibModal, flash, listArtistsFactory) {
        $scope.artists = listArtistsFactory.query();
        $rootScope.flash = flash;

        $scope.itemsPerPage = 10
        $scope.currentPage = 1;
        $scope.pageCount = function () {
            return Math.ceil($scope.artists.length / $scope.itemsPerPage);
        };
        $scope.artists.$promise.then(function () {
            $scope.totalItems = $scope.artists.length;
            $scope.$watch('currentPage + itemsPerPage', function() {
                var begin = (($scope.currentPage - 1) * $scope.itemsPerPage),
                    end = begin + $scope.itemsPerPage;
                $scope.filteredArtist = $scope.artists.slice(begin, end);
            });
        });

        //modal
        $scope.open = function (a) {
            $scope.a = a;
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'myModalContent.html',
                controller: 'ModalArtistInstanceCtrl',
                size: 'sm',
                resolve: {
                    artist: function () {
                        return $scope.a;
                    }
                }
            });
        }

    }]);

myApp.controller('ArtistAddCtrl', ['$scope', '$rootScope', '$http', '$location', 'flash', 'listRolesFactory',
    function($scope, $rootScope, $http, $location, flash, listRolesFactory) {
        $scope.artist = {}
        $scope.allowDelete = false;
        $rootScope.flash = flash;

        $scope.roleList = listRolesFactory.query();

        $scope.add = function(artist) {
            $http.post(
                laroute.url('artists/create', []),
                artist
            ).success(function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $scope.flash.set({type:'success', 'message':'Album agregado correctamente'});
                        $location.path('/artist');
                    } else if (data.status == 'validation_error') {
                        $scope.error = data.messages;
                    }
                }).error(function(error) {
                    console.log(error);
                });
        }

        //add multiple roles
        $scope.roles = [{'id':1}];

        $scope.addNewRole = function() {
            var newItemNo = $scope.roles.length+1;
            $scope.roles.push({'id':'choice'+newItemNo});
            $scope.allowDelete = true;
        };

        $scope.removeRole = function() {
            var lastItem = $scope.roles.length-1;
            if (lastItem == 1) {
                $scope.allowDelete = false;
            }
            $scope.roles.splice(lastItem);
        };
    }]);

myApp.controller('ArtistEditCtrl', ['$scope', '$rootScope', '$http', '$routeParams', '$location', 'flash',
    'listRolesFactory',
    function($scope, $rootScope, $http, $routeParams, $location, flash, listRolesFactory) {
        $rootScope.flash = flash;
        $scope.roleList = listRolesFactory.query();
        $scope.roles = [];
        $http.get(laroute.url('artists/detail', [$routeParams.id])).success(function(data) {
            var r = data.roles;
            $scope.artist = data;
            $scope.artist.rol = [];
            for(var i = 0; i < r.length; i++) {
                $scope.artist.rol[i] = r[i].id;
                $scope.roles.push({'id':i});
            }
            $scope.allowDelete = $scope.roles.length > 1;
        });

        $scope.edit = function(artist) {
            $http.put(
                laroute.url('artists/edit', [$routeParams.id]),
                artist
            ).success(function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $scope.flash.set({type:'success', 'message':'Album editado correctamente'});
                        $location.path('/artistas');
                    } else if (data.status == 'validation_error') {
                        $scope.error = data.messages;
                    }
                }).error(function(error) {
                    console.log(error);
                });
        }

        //add multiple roles
        $scope.addNewRole = function() {
            var newItemNo = $scope.roles.length+1;
            $scope.roles.push({'id':'choice'+newItemNo});
            $scope.allowDelete = true;
        };

        $scope.removeRole = function() {
            var lastItem = $scope.roles.length-1;
            if (lastItem == 1) {
                $scope.allowDelete = false;
            }
            $scope.roles.splice(lastItem);
            $http.get(laroute.url('artists/role/delete', [$routeParams.id, lastItem])).success(function(data) {

            });
        };
    }
]);

myApp.controller('ArtistDetailCtrl', ['$scope', '$http', '$routeParams', function($scope, $http, $routeParams) {
    $http.get(laroute.url('artists/detail', [$routeParams.id])).success(function(data) {
        $scope.artist = data;
    });
}]);

//modals
myApp.controller('ModalAlbumInstanceCtrl', function ($scope, $http, $route, $uibModalInstance, album) {

    $scope.album = album;
    $scope.delete = function (id) {
        $http.delete(laroute.url('albums/delete', [id])).success(function(data) {
            $route.reload()
            $uibModalInstance.dismiss('cancel');
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

myApp.controller('ModalArtistInstanceCtrl', function ($scope, $http, $route, $uibModalInstance, artist) {

    $scope.artist = artist;
    $scope.delete = function (id) {
        $http.delete(laroute.url('artists/delete', [id])).success(function(data) {
            $route.reload()
            $uibModalInstance.dismiss('cancel');
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

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
