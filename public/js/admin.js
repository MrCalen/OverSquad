angular.module('OverSquad', [])
.controller('OverSquadController', function ($scope, $http, $timeout) {
    $scope.rooms = [];

    $scope.auth = function () {
        $scope.ws.send(JSON.stringify({
            type: 'auth',
            token: window.token,
            admin: window.admin
        }));
    };

    $scope.ws = new WebSocket(window.websocketUrl);
    $scope.ws.onopen = function () {
        $scope.auth();
    };

    $scope.ws.onmessage = function (message) {
        message = JSON.parse(message.data);
        $scope.rooms = message;
        $scope.$apply();
    };

    $scope.roles = {
        1: 'attack',
        2: 'tank',
        4: 'support',
        5: 'defense'
    };

    $scope.roleToString = function (role) {
        return $scope.roles[role];
    };

    $scope.emptyPlaces = function (room) {
        var res = [];
        for (var i = 0; i < 6 - room.length; ++i)
            res.push(i);
        return res;
    }
});
