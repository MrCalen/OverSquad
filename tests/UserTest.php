<?php

use App\User;

class UserTest extends TestCase
{
    /**
     * Test getLevel().
     *
     * @return void
     */
    public function testGetLevel()
    {
        $player = new User();
        $player->gametag = "Hughlekrogan-2365";
        $this->assertTrue($player->getLevel() == 31);
    }
}
