<?php

namespace App\Ws;

use App\Models\PlayersManager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $connections = [];
    protected $playerManager;

    public function __construct()
    {
        $this->playerManager = new PlayersManager();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections[$conn->resourceId] = new Connection($conn);
    }

    public function onClose(ConnectionInterface $conn)
    {
        unset($this->connections[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        var_dump($e);
        $this->onClose($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        // TODO: Implement onMessage() method.

        $json_msg = json_decode($msg);
        if (!$json_msg) {
            return;
        }

        if ($json_msg->type === 'auth') {
            $token = $json_msg->token;
            $roles = $json_msg->roles;
            // FIXME: Get user from token;
            $user = null;
            $this->connections[$from->resourceId]->setUser($user);
            $this->playerManager->userConnected($user, $roles);
        }

    }
}
