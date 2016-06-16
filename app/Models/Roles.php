<?php

namespace App\Models;

/**
 * Enum Roles
 * @package App\Models
 */
abstract class Roles
{
    /**
     * Constants
     */
    const ATTACK = 1; // 3
    const TANK = 2; // 1
    const SUPPORT = 3; // 1
    const DEFENSE = 4; // 1

    /**
     * Creates an associative array for each role
     */
    public static $ROLES = [
        Roles::ATTACK => 'attack',
        Roles::TANK => 'tank',
        Roles::SUPPORT => 'support',
        Roles::DEFENSE => 'defense',
    ];

    /**
     * FIXME: Maybe useless
     */
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

    /**
     * Returns the string corresponding to the given role
     */
    public static function stringToRole($str)
    {
        return array_flip(self::$ROLES)[$str];
    }

    /**
     * @param $role : The role
     * @return int : The number of places per room for the given role
     */
    public static function maxPerRole($role)
    {
        switch ($role) {
            case 'attack':
                return 3;
            default:
                return 1;
        }
    }
}
