<?php

namespace App\Models;

use App\Ws\Connection;

class Room
{
    private $assoc;
    private $id;

    private static $count = 0;

    public function __construct()
    {
        foreach (Roles::$ROLES as $role => $roleName) {
            $name = $roleName;
            $this->{ $name } = [];
            $this->assoc[$role] = $roleName;
        }

        $this->id = self::$count++;
    }

    public function playerJoin($connection, $userRoles)
    {
        $missingRoles = $this->missingRoles();
        foreach ($userRoles as $userRole) {
            if (in_array(Roles::$ROLES[$userRole], $missingRoles)) {
                $this->assignPlayerToRole($connection, $userRole);
                return $this;
            }
        }
        return null;
    }

    public function assignPlayerToRole(Connection $connection, $role)
    {
        // Dark magic by @calen
        $this->{ $this->assoc[$role] }[] = $connection;
        $connection->setRole($role);
    }

    public function checkFull()
    {
        return count($this->missingRoles()) === 0;
    }

    public function removeUser(Connection $connection)
    {
        $playersInRoles = $this->{ $this->assoc[$connection->getRole()] };
        unset($playersInRoles[array_search($connection, $playersInRoles)]);
    }

    private function missingRoles()
    {
        $missingRoles = [];
        foreach (Roles::$ROLES as $role) {
            if (count($this->propertyForRole($role)) < Roles::maxPerRole($role)) {
                $missingRoles[] = $role;
            }
        }
        return $missingRoles;
    }

    private function propertyForRole($role)
    {
        return $this->{ $this->assoc[Roles::stringToRole($role)] };
    }

    public function getId()
    {
        return $this->id;
    }
}
