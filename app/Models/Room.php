<?php

namespace App\Models;

use App\Ws\Connection;

/**
 * Class Room
 * Handle connections of user in rooms
 * @package App\Models
 */
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

    /**
     * @param $connection : User
     * @param $userRoles : Roles wanted by a user
     * @return Room|null : Returns an open room or null if none is found
     */
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

    /**
     * Assigns a Player to a role
     * @param Connection $connection : User
     * @param $role : Role
     */
    public function assignPlayerToRole(Connection $connection, $role)
    {
        // Dark magic by @calen
        $this->{ $this->assoc[$role] }[] = $connection;
        $connection->setRole($role);
    }

    /**
     * Checks if the room is full or not
     * @return bool : true is the room is full
     */
    public function checkFull()
    {
        return count($this->missingRoles()) === 0;
    }

    /**
     * Handle user disconnection
     * @param Connection $connection : User
     */
    public function removeUser(Connection $connection)
    {
        $playersInRoles = $this->{ $this->assoc[$connection->getRole()] };
        unset($playersInRoles[array_search($connection, $playersInRoles)]);
    }

    /**
     * @return array : The role fillable by a user
     */
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

    /**
     * @param $role : The role
     * @return mixed : the property for the role given
     */
    private function propertyForRole($role)
    {
        return $this->{ $this->assoc[Roles::stringToRole($role)] };
    }

    /**
     * @return int : The unique id of the room
     */
    public function getId()
    {
        return $this->id;
    }
}
