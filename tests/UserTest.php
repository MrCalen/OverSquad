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

    public function testgetHeroIconWithRank()
    {
        $player = new User();
        $player->gametag = "Hughlekrogan-2365";
        $player->hero1 = "Reinhardt-5 hours";
        $this->assertTrue($player->getHeroIconWithRank(1) === "https://blzgdapipro-a.akamaihd.net/hero/reinhardt/icon-right-menu.png");
    }

    public function testCheckHeroName()
    {
        $player = new User();
        assert(UtilsTest::invokeMethod($player, 'checkHeroName', ['lúcio']) === 'lucio');
        assert(UtilsTest::invokeMethod($player, 'checkHeroName', ['tobjörn']) === 'tobjorn');
        assert(UtilsTest::invokeMethod($player, 'checkHeroName', ['soldier: 76']) === 'soldier-76');
        assert(UtilsTest::invokeMethod($player, 'checkHeroName', ['d.va']) === 'dva');
    }

    public function testGetHeroTimeWithRank()
    {
        $player = new User();
        $player->gametag = "Hughlekrogan-2365";
        $player->hero1 = "Reinhardt-5 hours";
        $this->assertTrue($player->getHeroTimeWithRank(1) === "5 hours");
    }

    public function testGetHeroNameWithRank()
    {
        $player = new User();
        $player->gametag = "Hughlekrogan-2365";
        $player->hero1 = "Reinhardt-5 hours";
        $this->assertTrue($player->getHeroNameWithRank(1) === "Reinhardt");
    }

    public function testgetHeroWithRankFromGametag()
    {
        $this->assertTrue(User::getHeroWithRankFromGametag(1, "Hughlekrogan-2365") === "Roadhog-5 hours");
        $this->assertTrue(User::getHeroWithRankFromGametag(1, "test-2365") === "");
    }
}
