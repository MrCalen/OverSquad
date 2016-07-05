String.format = function () {
    var theString = arguments[0];

    for (var i = 1; i < arguments.length; i++) {
        var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
        theString = theString.replace(regEx, arguments[i]);
    }

    return theString;
};

angular.module('OverSquad', [])
    .controller('OverSquadController', function ($scope, $http, $timeout, $sce) {
        $scope.step = 0;
        $scope.players = [];
        $scope.roomStatus = false;
        $scope.messages = [];
        $scope.roles = [];
        $scope.const_roles = {
            1: 'attack',
            2: 'tank',
            3: 'support',
            4: 'defense'
        };


        $scope.addRole = function (value) {
            if ($scope.roles.find(function (elt) {
                    return elt.value === value;
                }))
                return;
            $scope.roles.push({
                name: $scope.const_roles[value],
                value: value
            });
        };

        $scope.removeRole = function (index) {
            $scope.roles.splice(index, 1);
        };

        $scope.endWaiting = function () {
            if (!$scope.roomStatus) return;
            var str = "<h4>Every user is ready ! Here is the list of GameTag:</h4><ul>";
            $scope.players.forEach(function (player) {
                str += "<li>" + player.user.name + ' : <b>' + player.user.gametag + "</b></li>";
            });
            str += "</ul>";
            $scope.messages.push({
                author_name: 'OverSquad Bot',
                content: $sce.trustAsHtml(str),
                bot: true
            });
            $scope.$apply();
        };

        $scope.start = function () {
            $scope.playerRoles = [];
            angular.copy($scope.roles).forEach(function (elt) {
                $scope.playerRoles.push(elt.value);
            });
            $scope.step = 1;

            /* Popup before leaving room */
            $(window).bind('beforeunload', function () {
                return 'Are you sure you want to leave the room?';
            });

            /* Handle WebSocket connection */
            $scope.auth = function (roles) {
                $scope.ws.send(JSON.stringify({
                    type: 'auth',
                    token: window.token,
                    roles: roles
                }));
            };

            $scope.ws = new WebSocket(window.websocketUrl);
            $scope.ws.onopen = function () {
                $scope.auth($scope.playerRoles);
            };

            $scope.ws.onmessage = function (message) {
                message = JSON.parse(message.data);
                if (message.type === 'users') {
                    $scope.players = message.players;
                    $scope.roomStatus = message.status;
                    if ($scope.roomStatus) {
                        $scope.endWaiting();
                    }
                    $scope.$apply();
                } else if (message.type === 'message') {
                    $scope.messages.push(message);
                    $scope.$apply();
                }
            };

            $scope.newMessage = function (message) {
                if (message.length === 0)
                    return;
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

                        var template =
                            '<div class="container-fluid row">' +
                            '  <div class="col-xs-6">' +
                            '    <img class="img img-responsive" src="{4}"/>' +
                            '  </div>' +
                            '  <div class="col-xs-6"> ' +
                            '       <h3>{0}</h3>' +
                            '  </div>' +
                            '</div>' +
                            '<ul class="list-group" style="margin-top: 15px;">' +
                            '   <li class="list-group-item"><strong>Battletag</strong>: {1}</li>' +
                            '   <li class="list-group-item"><strong>Level</strong>: {2}</li>' +
                            '   <li class="list-group-item"><strong>Role</strong>: {3}</li>' +
                            '</ul>';

                        var player = null;
                        for (var i = 0; i < $scope.players.length; i++) {
                            var current = $scope.players[i];
                            if (current.user.id == id) {
                                player = current;
                                break;
                            }
                        }

                        var content = String.format(template,
                            player.user.name,
                            player.user.gametag,
                            player.user.level,
                            $scope.const_roles[player.role],
                            player.user.picture
                        );

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

        };

    });