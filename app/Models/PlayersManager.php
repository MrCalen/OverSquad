<?php

namespace App\Models;

use App\Ws\Connection;

class PlayersManager
{
    private $rooms = [];

    public function userConnected(Connection $connection, $roles)
    {
        $userRoles = [];
        foreach ($roles as $role) {
            $userRoles[] = Roles::intToRole($role);
        }

        $newRoom = null;
        foreach ($this->rooms as $roomId => $room) {
            if (($newRoom = $room->playerJoin($connection, $userRoles)) != null) {
                break;
            }
        }
        if (!$newRoom) {
            $newRoom = $this->createRoom($connection, $userRoles);
        }

        $connection->setRoom($newRoom);
    }

    private function createRoom($connection, $userRoles)
    {
        // The player takes its most wanted place
        $room = new Room();
        $room->assignPlayerToRole($connection, $userRoles[0]);
        $this->rooms[$room->getId()] = $room;
        return $room;
    }

    public function userLeave(Connection $connection)
    {
        if (!$connection->getRoom()) {
            return;
        }
        $connection->getRoom()->removeUser($connection);
    }
}
