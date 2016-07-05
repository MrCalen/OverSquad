<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Log;
use PHPHtmlParser\Dom;
use stringEncode\Exception;

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

    public static function loadProfilePage($gametag)
    {
        $dom = new Dom;
        $gametagModified = str_replace("#", "-", $gametag);
        return $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $gametagModified);
    }

    public function refreshPlayerLevelAndHeroes()
    {
        $dom = self::loadProfilePage($this->gametag);

        $this->rank_url = User::getRank($dom);
        $level = self::getLevelFromGametag($this->gametag, $dom);
        $this->level = $level;
        $hero1 = $this->getHeroWithRank(0, $dom);
        $hero2 = $this->getHeroWithRank(1, $dom);
        $hero3 = $this->getHeroWithRank(2, $dom);

        $this->hero1 = $hero1;
        $this->hero2 = $hero2;
        $this->hero3 = $hero3;
        $this->save();
    }

    public static function getRank($dom)
    {
        if (!$dom) {
            $dom = self::loadProfilePage($dom);
        }

        $rank = $dom->find('.player-rank');
        if (!isset($rank[0])) {
            return null;
        }
        $tag = $rank[0]->tag;
        $rank = $tag->getAttributes();
        $rank = $rank['style']['value'];
        return $rank;
    }

    public function getLevel()
    {
        return self::getLevelFromGametag($this->gametag);
    }

    public static function getLevelFromGametag($gametag, $dom = null)
    {
        try {
            if ($dom === null) {
                $dom = self::loadProfilePage($gametag);
            }

            $find = $dom->find('.player-level')[0];
            if (!$find) {
                return 0;
            }

            return $find->firstChild()->text;

        } catch (Throwable $e) {
            return '';
        }
    }

    public function getHeroes()
    {
        return self::getHeroesFromGametag($this->gametag);
    }

    public static function getHeroesFromGametag($gametag, $dom = null)
    {
        $list = [];
        try {
            if ($dom === null) {
                $dom = self::loadProfilePage($gametag);
            }

            $nameList = [];
            $timeList = [];
            $list = [];

            $progressCategory = $dom->find('.progress-category', 0);
            if (is_null($progressCategory)) {
                return $list;
            }

            foreach ($progressCategory->find('.title') as $node) {
                $nameList[] = $node->text;
            }

            foreach ($progressCategory->find('.description') as $node) {
                $timeList[] = $node->text;
            }

            for ($i = 0; $i < count($nameList); ++$i) {
                $list[$i] = $nameList[$i] . '-' . $timeList[$i];
            }
        } catch (Throwable $t) {
        } catch (Exception $e) {
        }
        return $list;
    }

    public function getHeroWithRank($rank, $dom = null)
    {
        $list = self::getHeroesFromGametag($this->gametag, $dom);
        if (count($list) > 0) {
            return $list[$rank];
        } else {
            return '';
        }
    }

    public static function getHeroWithRankFromGametag($rank, $gametag, $dom = null)
    {
        $list = self::getHeroesFromGametag($gametag, $dom);
        if (count($list) > 0) {
            return $list[$rank];
        } else {
            return '';
        }
    }

    public function getHeroNameWithRank($rank)
    {
        if ($this->{'hero' . $rank} === '') {
            return 'No Hero';
        }
        return strstr($this->{'hero' . $rank}, '-', true);
    }

    public function getHeroTimeWithRank($rank)
    {
        return substr(strstr($this->{'hero' . $rank}, '-'), 1);
    }

    private function checkHeroName($name)
    {
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

    public function getHeroIconWithRank($rank)
    {
        if ($this->{'hero' . $rank} === '') {
            return "https://blzgdapipro-a.akamaihd.net/hero/winston/ability-primal-rage/icon-ability.png";
        }
        return "https://blzgdapipro-a.akamaihd.net/hero/"
                . self::checkHeroName(strtolower(strstr($this->{'hero' . $rank}, '-', true)))
                . "/icon-right-menu.png";
    }
}
