<?php

namespace App\Ws;

use App\Models\PlayersManager;
use App\Models\Room;
use App\User;
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
        try {
            $connection = $this->connections[$conn->resourceId];
            $room = $this->playerManager->userLeave($connection);
            unset($this->connections[$conn->resourceId]);
            $this->notifyRoomChanged($room);
        } catch (\Throwable $e) {
        }
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
        if (!$json_msg || !isset($json_msg->token)) {
            return;
        }
        $token = $json_msg->token;
        JWTAuth::setToken($token);
        $user = JWTAuth::toUser();
        if (!$user) {
            return;
        }
        $connection = $this->connections[$from->resourceId];
        if ($json_msg->type === 'auth') {
            $connection->setUser($user);
            if ($user->admin && isset($json_msg->admin) && $json_msg->admin) {
                $this->getRooms($connection);
                return;
            }
            $roles = $json_msg->roles;
            $room = $this->playerManager->userConnected($connection, $roles);
            $this->notifyRoomChanged($room);
        } elseif ($json_msg->type === 'message') {
            $message = $json_msg->content;
            $room = $connection->getRoom();
            $this->notifyRoomMessage($room, $user, $message);
        }
    }

    private function getRooms(Connection $connection)
    {
        $rooms = $this->playerManager->getRooms();
        $connection->getConnection()->send(json_encode($rooms));
    }

    private function notifyRoomChanged(Room $room)
    {
        $this->notifyRoom($room, [
            'type' => 'users',
            'players' => $room,
            'status' => $room->checkFull(),
        ]);
    }

    private function notifyRoomMessage(Room $room, User $user, $message)
    {
        $this->notifyRoom($room, [
            'type' => 'message',
            'content' => $message,
            'author' => $user->id,
            'author_name' => $user->name,
        ]);
    }

    private function notifyRoom(Room $room, $message)
    {
        if (!$room) {
            return;
        }

        foreach ($room->getCurrentPlayers() as $player) {
            $player->getConnection()->send(json_encode($message));
        }
    }
}
