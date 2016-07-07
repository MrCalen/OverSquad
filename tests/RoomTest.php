<?php

use App\Models\Room;
use App\Models\Roles;
use App\Ws\Connection;
use App\User;

class RoomTest extends TestCase
{
    /**
     * Test __construct().
     *
     * @return void
     */
    public function testConstructor()
    {
        $room = new Room();
        $room2 = new Room();
        assert($room->getId() !== $room2);
    }

    /**
     * Test missingRoles().
     *
     * @return void
     */
    public function testMissingRoles()
    {
        $room = new Room();
        assert(UtilsTest::invokeMethod($room, 'missingRoles', []) === ['attack', 'tank', 'support', 'defense']);
        $conn = new Connection(null);
        $conn->setUser(new User());
        $room->playerJoin($conn, [Roles::SUPPORT]);
        assert(UtilsTest::invokeMethod($room, 'missingRoles', []) === ['attack', 'tank', 'defense']);
    }

    /**
     * Test propertyForRole().
     *
     * @return void
     */
    public function testPropertyForRole()
    {
        $room = new Room();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $room->playerJoin($conn, [Roles::ATTACK]);
        assert(count(UtilsTest::invokeMethod($room, 'propertyForRole', ['attack'])) === 1);
    }

    /**
     * Test RemoveUser().
     *
     * @return void
     */
    public function testRemoveUser()
    {
        $room = new Room();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $room->playerJoin($conn, [Roles::ATTACK]);

        assert(count($room->getCurrentPlayers()) === 1);
        $room->removeUser($conn);
        assert(count($room->getCurrentPlayers()) === 0);
    }

    /**
     * Test CheckFull().
     *
     * @return void
     */
    public function testCheckFullFalse()
    {
        $room = new Room();

        assert($room->checkFull() === false);
        $conn = new Connection(null);
        $conn->setUser(new User());
        $room->playerJoin($conn, [Roles::ATTACK]);

        assert($room->checkFull() === false);
    }

    /**
     * Test CheckFull().
     *
     * @return void
     */
    public function testCheckFullTrue()
    {
        $room = new Room();

        assert($room->checkFull() === false);
        $conns = array();
        for ($i = 0; $i < 6; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $room->playerJoin($conns[0], [Roles::ATTACK]);
        $room->playerJoin($conns[1], [Roles::TANK]);
        $room->playerJoin($conns[2], [Roles::SUPPORT]);
        $room->playerJoin($conns[3], [Roles::DEFENSE]);
        $room->playerJoin($conns[4], [Roles::ATTACK]);
        $room->playerJoin($conns[5], [Roles::ATTACK]);
        assert($room->checkFull() === true);
    }

    /**
     * Test GetCurrentPlayers().
     *
     * @return void
     */
    public function testGetCurrentPlayers()
    {
        $room = new Room();
        $conns = array();
        for ($i = 0; $i < 6; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $room->playerJoin($conns[0], [Roles::ATTACK]);
        $room->playerJoin($conns[1], [Roles::TANK]);
        $room->playerJoin($conns[2], [Roles::SUPPORT]);
        $room->playerJoin($conns[3], [Roles::DEFENSE]);

        assert(count($room->getCurrentPlayers()) === 4);
    }

    /**
     * Test jsonSerialize().
     *
     * @return void
     */
    public function testJsonSerialize()
    {
        $room = new Room();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $room->playerJoin($conn, [Roles::ATTACK]);

        assert(count($room->jsonSerialize()) === 1);
    }

    /**
     * Test playerJoin().
     *
     * @return void
     */
    public function testPlayerJoinNoPlace()
    {
        $room = new Room();

        assert($room->checkFull() === false);
        $conns = array();
        for ($i = 0; $i < 7; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $room->playerJoin($conns[0], [Roles::ATTACK]);
        $room->playerJoin($conns[1], [Roles::TANK]);
        $room->playerJoin($conns[2], [Roles::SUPPORT]);
        $room->playerJoin($conns[3], [Roles::DEFENSE]);
        $room->playerJoin($conns[4], [Roles::ATTACK]);
        $room->playerJoin($conns[5], [Roles::ATTACK]);
        assert($room->playerJoin($conns[6], [Roles::ATTACK]) === null);
    }

    public function testIsLocked()
    {
        $room = new Room();

        $this->assertTrue($room->isLocked() === false);
        $conns = array();
        for ($i = 0; $i < 7; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $room->playerJoin($conns[0], [Roles::ATTACK]);
        $room->playerJoin($conns[1], [Roles::TANK]);
        $room->playerJoin($conns[2], [Roles::SUPPORT]);
        $room->playerJoin($conns[3], [Roles::DEFENSE]);
        $room->playerJoin($conns[4], [Roles::ATTACK]);
        $room->playerJoin($conns[5], [Roles::ATTACK]);
        $room->checkFull();
        $this->assertTrue($room->isLocked());
        assert($room->playerJoin($conns[6], [Roles::ATTACK]) === null);

    }

}
