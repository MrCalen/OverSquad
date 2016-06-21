<?php

namespace App\Ws;

use App\Models\PlayersManager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use JWTAuth;

/**
 * The Server handling WebSocket Connection
 *
 * Class WebSocketServer
 * @package App\Ws
 *
 */
class WebSocketServer implements MessageComponentInterface
{
    protected $connections = [];
    protected $playerManager;

    public function __construct()
    {
        $this->playerManager = new PlayersManager();
    }

    /**
     * Create a Connection Instance from the Interface
     *
     * @param ConnectionInterface $conn : The User
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[$conn->resourceId] = new Connection($conn);
    }

    /**
     * The User disconnection
     *
     * @param ConnectionInterface $conn : The User
     */
    public function onClose(ConnectionInterface $conn)
    {
        $connection = $this->connections[$conn->resourceId];
        $room = $this->playerManager->userLeave($connection);
        unset($this->connections[$conn->resourceId]);
        $this->notifyRoomChanged($room);
    }

    /**
     * Handles Exceptions in WebSockets
     *
     * @param ConnectionInterface $conn : The User
     * @param \Exception $e : Exception
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        var_dump($e);
        $this->onClose($conn);
    }

    /**
     * Handle Message sent by the client
     *
     * @param ConnectionInterface $from : The User
     * @param string $msg : The Message
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $json_msg = json_decode($msg);
        if (!$json_msg) {
            return;
        }

        if ($json_msg->type === 'auth') {
            $token = $json_msg->token;
            $roles = $json_msg->roles;
            JWTAuth::setToken($token);
            $user = JWTAuth::toUser();
            if (!$user) {
                return;
            }
            $connection = $this->connections[$from->resourceId];
            $connection->setUser($user);
            $room = $this->playerManager->userConnected($connection, $roles);
            $this->notifyRoomChanged($room);
        }
    }

    private function notifyRoomChanged($room)
    {
        if (!$room) {
            return;
        }

        foreach ($room->getCurrentPlayers() as $player) {
            $player->getConnection()->send(json_encode([
                'players' => $room,
                'status' => $room->checkFull(),
            ]));
        }
    }
}
