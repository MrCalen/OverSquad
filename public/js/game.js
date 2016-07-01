String.format = function() {
    var theString = arguments[0];

    for (var i = 1; i < arguments.length; i++) {
        var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
        theString = theString.replace(regEx, arguments[i]);
    }

    return theString;
};

angular.module('OverSquad', [])
    .controller('OverSquadController', function ($scope, $http, $timeout) {
    $scope.players = [];
    $scope.roomStatus = false;
    $scope.messages = [];

    $scope.auth = function (roles) {
        $scope.ws.send(JSON.stringify({
            type: 'auth',
            token: window.token,
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
            $scope.messages.push(message);
            $scope.$apply();
        }
    };

    $scope.newMessage = function (message) {
        $scope.ws.send(JSON.stringify({
            type: 'message',
            content: message,
            token: window.token
        }));
    };

    $(document).ready(function () {
        var register = function () {
            $(".user-hover").off('mouseenter mouseleave').hover(function () {
                var $this = this;
                if (!$this.hasAttribute('id')) return;
                var id = $this.getAttribute('id');
                $('.popover').remove();

                var template = '<div class="container-fluid row">' +
                    '<div class="col-xs-6">' +
                    '<img class="img img-responsive" src="{0}"/>' +
                    ' </div>' +
                    ' <div class="col-xs-6"> ' +
                    '<h3>{1}</h3> ' +
                    '</div>' +
                    ' </div>';

                var player = null;
                for (var i = 0; i < $scope.players.length; i++) {
                    var current = $scope.players[i];
                    if (current.user.id == id) {
                        player = current;
                        break;
                    }
                }

                var content = String.format(template, player.user.picture, player.user.name);
                console.log(content);
                $($this).popover({
                    placement: 'left',
                    content: content,
                    container: $('body'),
                    html: true
                }).popover('show');
            }, function () {
                $('.popover').remove();
            });
        };

        $(function () {
            setTimeout(register, 500);
        });
    });
});