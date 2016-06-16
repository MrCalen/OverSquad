<?php


namespace App\Ws;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $connections = [];

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
    }
}
