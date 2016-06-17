angular.module('OverSquad', []).controller('OverSquadController', function ($scope) {
    $scope.players = [];
    $scope.roomStatus = false;

    $scope.auth = function (roles) {
        $scope.ws.send(JSON.stringify({
            type: 'auth',
            token: token,
            roles: roles
        }));
    };

    $scope.ws = new WebSocket("ws://oversquad.mr-calen.eu/ws");
    $scope.ws.onopen = function () {
        $scope.auth([1, 2]);
    };

    $scope.ws.onmessage = function (message) {
        message = JSON.parse(message.data);
        $scope.players = message.players;
        $scope.roomStatus = message.status;
        console.log($scope.players);
        $scope.$apply();
    };

});