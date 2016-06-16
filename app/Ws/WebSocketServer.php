<?php

namespace App\Ws;

use App\Models\PlayersManager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

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
        unset($this->connections[$conn->resourceId]);
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
            // FIXME: Get user from token;
            $user = null;
            $this->connections[$from->resourceId]->setUser($user);
            $this->playerManager->userConnected($user, $roles);
        }

    }
}
