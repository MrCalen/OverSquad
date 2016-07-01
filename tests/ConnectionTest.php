<?php

use App\Ws\Connection;
use App\User;
use App\Models\Roles;

class ConnectionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test GetConnection().
     *
     * @return void
     */
    public function testGetConnection()
    {
        $conn = new Connection(null);
        $this->assertTrue($conn->getConnection() === null);
        $conn->setConnection(new Connection(null));
        $this->assertTrue($conn->getConnection() !== null);
    }

    /**
     * Test SetConnection().
     *
     * @return void
     */
    public function testSetConnection()
    {
        $conn = new Connection(null);
        $conn->setConnection(new Connection(null));
        $this->assertTrue($conn->getConnection() !== null);
    }

    /**
     * Test SetUser().
     *
     * @return void
     */
    public function testSetUser()
    {
        $conn = new Connection(null);
        $user = new User();

        $conn->setUser($user);
        $this->assertTrue($conn->getUser() !== null);
    }

    /**
     * Test jsonSerialize().
     *
     * @return void
     */
    public function testSerialize()
    {
        $conn = new Connection(null);
        $user = new User();
        $conn->setRole(Roles::ATTACK);
        $conn->setUser($user);
        $this->assertTrue($conn->jsonSerialize()['user'] !== null);
    }

}
