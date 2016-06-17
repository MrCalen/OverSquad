<?php

namespace App\Ws;

use App\User;

class Connection implements \JsonSerializable
{
    protected $connection;
    protected $user;

    protected $room;
    protected $role;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getId()
    {
        return $this->user->id;
    }

    public function getRoom()
    {
        return $this->room;
    }

    public function setRoom($room)
    {
        $this->room = $room;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function jsonSerialize()
    {
        return [
            "user" => $this->user,
            "role" => $this->role,
        ];
    }
}
