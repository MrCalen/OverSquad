<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;
use Log;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gametag', 'level', 'picture', 'hero1', 'hero2', 'hero3'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        'created_at', 'updated_at',
    ];

    public function refreshPlayerLevelAndHeroes() {
        $level = $this->getLevel();
        $this->level = $level;
        $hero1 = $this->getHeroWithRank(0);
        $hero2 = $this->getHeroWithRank(1);
        $hero3 = $this->getHeroWithRank(2);
        $this->hero1 = $hero1;
        $this->hero2 = $hero2;
        $this->hero3 = $hero3;
        $this->save();
      }

    public function getLevel()
    {
        return self::getLevelFromGametag($this->gametag);
    }

    public static function getLevelFromGametag($gametag) {
        $dom = new Dom;
        $gametagModified = str_replace("#", "-", $gametag);
        try {
        $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $gametagModified);

        if (!$dom->find('.player-level')[0])
            return 0;

        return $dom->find('.player-level')[0]
            ->firstChild()
            ->text;
        } catch (Throwable $e) {
          return '';
        }
    }

    public function getHeroes()
    {
        return self::getHeroesFromGametag($this->gametag);
    }

    public static function getHeroesFromGametag($gametag)
    {
        $dom = new Dom;
        $gametagModified = str_replace("#", "-", $gametag);
        $list = [];
        try {
        $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $gametagModified);
        $nameList = [];
        $timeList = [];
        $list = [];

        if (is_null($dom->find('.progress-category', 0)))
          return $list;

        foreach ($dom->find('.progress-category', 0)->find('.title') as $node)
            $nameList[] = $node->text;

        foreach ($dom->find('.progress-category', 0)->find('.description') as $node)
            $timeList[] = $node->text;

        for ($i = 0; $i < count($nameList); ++$i)
            $list[$i] = $nameList[$i] . '-' . $timeList[$i];
      }  catch (Throwable $t) {
    // Executed only in PHP 7, will not match in PHP 5.x
      } catch (Exception $e) {
    // Executed only in PHP 5.x, will not be reached in PHP 7
      }
      return $list;
    }

    public function getHeroWithRank($rank)
    {
        $list = self::getHeroesFromGametag($this->gametag);
        if (count($list) > 0) {
          return $list[$rank];
        } else {
          return '';
        }
    }

    public static function getHeroWithRankFromGametag($rank, $gametag)
    {
        $list = self::getHeroesFromGametag($gametag);
        if (count($list) > 0) {
          return $list[$rank];
        } else {
          return '';
        }
    }

    public function getHeroNameWithRank($rank) {
      if ($this->{'hero' . $rank} === '')
        return 'No Hero';
      return strstr($this->{'hero' . $rank} , '-', true);
    }

    public function getHeroTimeWithRank($rank) {
        return substr(strstr($this->{'hero' . $rank} , '-'), 1);
    }

    private function checkHeroName($name) {
      switch ($name) {
        case 'lúcio':
          return 'lucio';
          break;
        case 'tobjörn':
          return 'tobjorn';
          break;
        case 'soldier: 76':
          return 'soldier-76';
          break;
        case 'd.va':
          return 'dva';
          break;
        default:
          return $name;
          break;
      }
    }

    public function getHeroIconWithRank($rank) {
      if ($this->{'hero' . $rank} === '')
        return "https://blzgdapipro-a.akamaihd.net/hero/winston/ability-primal-rage/icon-ability.png";
      return "https://blzgdapipro-a.akamaihd.net/hero/" . self::checkHeroName(strtolower(strstr($this->{'hero' . $rank} , '-', true))) . "/icon-right-menu.png";
    }
}
