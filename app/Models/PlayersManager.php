<?php

namespace App\Models;

use App\Ws\Connection;

/**
 * Class PlayersManager
 * @package App\Models
 * Manages all the connections of users
 */
class PlayersManager
{
    private $rooms = [];

    /**
     * Handle user connection
     *
     * @param Connection $connection : The connection
     * @param $roles : The roles wanted by the connection
     */
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

    /**
     * Creates a room (if no room has been found)
     * @param $connection : The user
     * @param $userRoles : The roles wanted by the user
     * @return Room : A new room
     */
    private function createRoom($connection, $userRoles)
    {
        // The player takes its most wanted place
        $room = new Room();
        $room->assignPlayerToRole($connection, $userRoles[0]);
        $this->rooms[$room->getId()] = $room;
        return $room;
    }

    /**
     * Handle User disconnection
     * @param Connection $connection : The User
     */
    public function userLeave(Connection $connection)
    {
        if (!$connection->getRoom()) {
            return;
        }
        $connection->getRoom()->removeUser($connection);
    }
}
