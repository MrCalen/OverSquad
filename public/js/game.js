angular.module('OverSquad', []).controller('OverSquadController', function ($scope) {
    $scope.players = [];
    $scope.roomStatus = false;
    $scope.messages = [];

    $scope.auth = function (roles) {
        $scope.ws.send(JSON.stringify({
            type: 'auth',
            token: token,
            roles: roles
        }));
    };

    $scope.ws = new WebSocket(window.websocketUrl);
    $scope.ws.onopen = function () {
        $scope.auth([1, 2]);
    };

    $scope.ws.onmessage = function (message) {
        message = JSON.parse(message.data);
        if (message.type === 'users') {
            $scope.players = message.players;
            $scope.roomStatus = message.status;
            $scope.$apply();
        } else if (message.type === 'message') {
            console.log(message);
            $scope.messages.push(message.content);
            $scope.$apply();
        }
    };

    $scope.newMessage = function (message) {
        $scope.ws.send(JSON.stringify({
            type: 'message',
            content: message,
            token: window.token
        }));
    }
});