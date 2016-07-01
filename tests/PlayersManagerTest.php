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
