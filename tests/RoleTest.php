<?php

use App\Models\Roles;

class RoleTest extends TestCase
{
    /**
     * Test intToRole().
     *
     * @return void
     */
    public function testIntToRole()
    {
        $this->assertTrue(Roles::intToRole(0) === -1);
        $this->assertTrue(Roles::intToRole(5) === -1);
        $this->assertTrue(Roles::intToRole(1) === Roles::ATTACK);
        $this->assertTrue(Roles::intToRole(2) === Roles::TANK);
        $this->assertTrue(Roles::intToRole(3) === Roles::SUPPORT);
        $this->assertTrue(Roles::intToRole(4) === Roles::DEFENSE);
    }

    /**
     * Test stringToRole().
     *
     * @return void
     */
    public function testStringToRole()
    {
        $this->assertTrue(Roles::stringToRole('attack') === Roles::ATTACK);
        $this->assertTrue(Roles::stringToRole('tank') === Roles::TANK);
        $this->assertTrue(Roles::stringToRole('support') === Roles::SUPPORT);
        $this->assertTrue(Roles::stringToRole('defense') === Roles::DEFENSE);
    }

    /**
     * Test maxPerRole().
     *
     * @return void
     */
    public function testMaxPerRole()
    {
        $this->assertTrue(Roles::maxPerRole('attack') === 3);
        $this->assertTrue(Roles::maxPerRole('tank') === 1);
        $this->assertTrue(Roles::maxPerRole('support') === 1);
        $this->assertTrue(Roles::maxPerRole('defense') === 1);
    }
}
