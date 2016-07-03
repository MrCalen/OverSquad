<?php

use App\Models\PlayersManager;
use App\Ws\Connection;
use App\Models\Roles;
use App\User;

class PlayersManagerTest extends TestCase
{
    /**
     * Test UserConnected().
     *
     * @return void
     */
    public function testUserConnected()
    {
        $pm = new PlayersManager();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $this->assertTrue($pm->userConnected($conn, [Roles::SUPPORT]) !== null);
        $this->assertTrue($pm->userConnected($conn, [Roles::ATTACK]) !== null);
    }

    /**
     * Test UserTwoRooms().
     *
     * @return void
     */
    public function testUserTwoRooms()
    {
        $pm = new PlayersManager();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $conns = array();
        for ($i = 0; $i < 7; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $pm->userConnected($conns[0], [Roles::ATTACK]);
        $pm->userConnected($conns[1], [Roles::TANK]);
        $pm->userConnected($conns[2], [Roles::SUPPORT]);
        $pm->userConnected($conns[3], [Roles::ATTACK]);
        $pm->userConnected($conns[4], [Roles::ATTACK]);
        $pm->userConnected($conns[5], [Roles::ATTACK]);
        $this->assertTrue(count($pm->getRooms()) == 2);
    }

    /**
     * Test lotsOfGame().
     *
     * @return void
     */
    public function testLotsOfGame()
    {
        $pm = new PlayersManager();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $conns = array();
        for ($i = 0; $i < 51; $i++)
        {
            $conn = new Connection(null);
            $conn->setUser(new User());
            array_push($conns, $conn);
        }
        $pm->userConnected($conns[0], [Roles::ATTACK]);
        $pm->userConnected($conns[1], [Roles::TANK]);
        $pm->userConnected($conns[2], [Roles::SUPPORT]);
        $pm->userConnected($conns[3], [Roles::ATTACK]);
        $pm->userConnected($conns[4], [Roles::ATTACK]);
        $this->assertTrue(count($pm->getRooms()) == 1);
        $pm->userConnected($conns[5], [Roles::ATTACK]);
        $this->assertTrue(count($pm->getRooms()) == 2);
        for ($i = 6; $i <= 12; $i++)
        {
            $pm->userConnected($conns[$i], [Roles::SUPPORT]);
            $this->assertTrue(count($pm->getRooms()) == 2 + $i - 6);
        }
        for ($i = 13; $i <= 25; $i++)
        {
            $pm->userConnected($conns[$i], [Roles::TANK]);
            $i++;
            $pm->userConnected($conns[$i], [Roles::DEFENSE]);
            $this->assertTrue(count($pm->getRooms()) == 8);
        }
        for ($i = 26; $i <= 46; $i++)
        {
            $pm->userConnected($conns[$i], [Roles::ATTACK]);
            $i++;
            $this->assertTrue(count($pm->getRooms()) == 8);
        }
        $pm->userConnected($conns[47], [Roles::ATTACK]);
        $pm->userConnected($conns[48], [Roles::TANK]);
        $pm->userConnected($conns[49], [Roles::SUPPORT]);
        $pm->userConnected($conns[50], [Roles::DEFENSE]);
        $this->assertTrue(count($pm->getRooms()) == 9);
    }

    /**
     * Test UserLeave().
     *
     * @return void
     */
    public function testUserLeave()
    {
        $pm = new PlayersManager();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $this->assertTrue($pm->userLeave($conn) === null);
        $this->assertTrue($pm->userConnected($conn, [Roles::SUPPORT]) !== null);
        $this->assertTrue($pm->userLeave($conn) !== null);
    }

    /**
     * Test CreateRoom().
     *
     * @return void
     */
    public function testCreateRoom()
    {
        $pm = new PlayersManager();
        $conn = new Connection(null);
        $conn->setUser(new User());
        $this->assertTrue(UtilsTest::invokeMethod($pm, 'CreateRoom', [$conn, [Roles::SUPPORT]]) !== null);
    }

    /**
     * Test GetRooms().
     *
     * @return void
     */
    public function testGetRooms()
    {
        $pm = new PlayersManager();
        $this->assertTrue($pm->getRooms() === []);
        $conn = new Connection(null);
        $conn->setUser(new User());
        $pm->userConnected($conn, [Roles::SUPPORT]);
        $this->assertTrue($pm->getRooms() !== []);
    }
}
