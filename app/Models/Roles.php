<?php

namespace App\Models;

abstract class Roles
{
    const ATTACK = 1; // 3
    const TANK = 2; // 1
    const SUPPORT = 3; // 1
    const DEFENSE = 4; // 1

    public static $ROLES = [
        Roles::ATTACK => 'attack',
        Roles::TANK => 'tank',
        Roles::SUPPORT => 'support',
        Roles::DEFENSE => 'defense',
    ];

    public static function intToRole($int)
    {
        switch ($int) {
            case 1:
                return Roles::ATTACK;
            case 2:
                return Roles::TANK;
            case 3:
                return Roles::SUPPORT;
            case 4:
                return Roles::DEFENSE;
        }
        return -1;
    }

    public static function maxPerRole($role)
    {
        switch ($role) {
            case Roles::ATTACK:
                return 3;
            default:
                return 1;
        }
    }
}
