<?php

namespace App\Models;

class Room
{
    private $attackPlayer;
    private $tankPlayer;
    private $supportPlayer;
    private $defensePlayer;

    private $assoc;

    public function __construct()
    {
        $this->attackPlayer = [];
        $this->tankPlayer = [];
        $this->supportPlayer = [];
        $this->defensePlayer = [];

        foreach (Roles::$ROLES as $role => $roleName) {
            $this->assoc[$role] = strtolower($roleName) . 'Player';
        }
    }

    public function playerJoin($user, $userRoles)
    {
        $missingRoles = $this->missingRoles();
        foreach ($userRoles as $userRole) {
            if (in_array($userRole, $missingRoles)) {
                $this->assignPlayerToRole($user, $userRole);
                return $this;
            }
        }
        return null;
    }

    public function assignPlayerToRole($user, $role)
    {
        // Dark magic by @calen
        $this->{ $this->assoc[$role] }[] = $user;
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
        return $this->{ $this->assoc[$role] };
    }
}
