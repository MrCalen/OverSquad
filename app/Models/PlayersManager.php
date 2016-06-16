<?php

namespace App\Models;

class PlayersManager
{
    private $rooms = [];

    public function __construct()
    {
        $this->rooms = [];
    }

    public function userConnected($user, $roles)
    {
        $userRoles = [];
        foreach ($roles as $role) {
            $userRoles[] = Roles::intToRole($role);
        }

        $newRoom = null;
        foreach ($this->rooms as $room) {
            if (($newRoom = $room->playerJoin($user, $roles)) != null) {
                break;
            }
        }
        if (!$newRoom) {
            $this->createRoom($user, $userRoles);
        }
    }

    private function createRoom($user, $userRoles)
    {
        // The player takes the most wanted place
        $room = new Room();
        $room->assignPlayerToRole($user, $userRoles[0]);
        $this->rooms[] = $room;
        return $room;
    }

    public function userLeave($user)
    {}
}
