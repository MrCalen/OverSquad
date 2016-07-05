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
        for ($i = 0; $i < 7; $i++) {
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
        $conns = [];
        for ($i = 0; $i < 50; $i++) {
            $conn = new Connection(null);
            $user = new User();
            $user->i = $i;
            $user->setCreatedAt($i);
            $conn->setUser($user);
            $conns[] = $conn;
        }

        $this->assertTrue(count($pm->getRooms()) == 0);
        $pm->userConnected($conns[0], [Roles::ATTACK]);
        $pm->userLeave($conns[0]);
        $this->assertTrue(count($pm->getRooms()) == 0);
        $pm->userConnected($conns[0], [Roles::ATTACK]);
        $pm->userConnected($conns[1], [Roles::TANK]);
        $pm->userConnected($conns[2], [Roles::SUPPORT]);
        $pm->userConnected($conns[3], [Roles::ATTACK]);
        $pm->userConnected($conns[4], [Roles::ATTACK]);
        $this->assertTrue(count($pm->getRooms()) == 1);
        $pm->userConnected($conns[5], [Roles::ATTACK]);
        $this->assertTrue(count($pm->getRooms()) == 2);
        for ($i = 6; $i <= 12; $i++) {
            $pm->userConnected($conns[$i], [Roles::SUPPORT]);
            $this->assertTrue(count($pm->getRooms()) == 2 + $i - 6);
        }
        for ($i = 13; $i <= 25; $i++) {
            $pm->userConnected($conns[$i], [Roles::TANK]);
            $i++;
            $pm->userConnected($conns[$i], [Roles::DEFENSE]);
            $this->assertTrue(count($pm->getRooms()) == 8);
        }
        for ($i = 27; $i <= 45; $i++) {
            $pm->userConnected($conns[$i], [Roles::ATTACK]);
            $this->assertTrue(count($pm->getRooms()) == 8);
        }
        $pm->userConnected($conns[46], [Roles::ATTACK]);
        $pm->userConnected($conns[47], [Roles::TANK]);
        $pm->userConnected($conns[48], [Roles::SUPPORT]);
        $pm->userConnected($conns[49], [Roles::DEFENSE]);
        $this->assertTrue(count($pm->getRooms()) == 9);

        // leave
        for ($i = 0; $i <= 4; $i++) {
            $pm->userLeave($conns[$i]);
        }
        $pm->userLeave($conns[14]);

        $this->assertTrue(count($pm->getRooms()) == 8);

        $pm->userConnected($conns[0], [Roles::ATTACK]);
        $pm->userConnected($conns[1], [Roles::TANK]);
        $pm->userConnected($conns[2], [Roles::SUPPORT]);
        $pm->userConnected($conns[3], [Roles::ATTACK]);
        $pm->userConnected($conns[4], [Roles::ATTACK]);
        $pm->userConnected($conns[14], [Roles::DEFENSE]);

        $this->assertTrue(count($pm->getRooms()) == 9);

        // make all attack leave
        $pm->userLeave($conns[0]);
        $pm->userLeave($conns[3]);
        $pm->userLeave($conns[4]);
        $pm->userLeave($conns[5]);
        for ($i = 27; $i <= 45; $i++) {
            $pm->userLeave($conns[$i]);
        }

        $pm->userLeave($conns[46]);
        $this->assertTrue(count($pm->getRooms()) == 9);

        // leave support
        for ($i = 6; $i <= 12; $i++) {
            $pm->userLeave($conns[$i]);
        }
        $this->assertTrue(count($pm->getRooms()) == 9);

        $pm->userLeave($conns[1]);
        $pm->userLeave($conns[2]);

        for ($i = 13; $i <= 26; $i++) {
            $pm->userLeave($conns[$i]);
        }

        $this->assertTrue(count($pm->getRooms()) == 2);

        $pm->userLeave($conns[46]);
        $pm->userLeave($conns[47]);
        $pm->userLeave($conns[48]);
        $pm->userLeave($conns[49]);
        $this->assertTrue(count($pm->getRooms()) == 0);
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
