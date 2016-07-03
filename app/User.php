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

    public function getLevel()
    {
        return self::getLevelFromGametag($this->gametag);
    }

    public static function getLevelFromGametag($gametag) {
        $dom = new Dom;
        $gametagModified = str_replace("#", "-", $gametag);
        $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $gametagModified);

        if (!$dom->find('.player-level')[0])
            return 0;

        return $dom->find('.player-level')[0]
            ->firstChild()
            ->text;
    }

    public function getHeroes()
    {
        return self::getHeroesFromGametag($this->gametag);
    }

    public static function getHeroesFromGametag($gametag)
    {
        $dom = new Dom;
        $gametagModified = str_replace("#", "-", $gametag);
        $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $gametagModified);
        $nameList = [];
        $timeList = [];
        $list = [];

        foreach ($dom->find('.progress-category', 0)->find('.title') as $node)
            $nameList[] = $node->text;

        foreach ($dom->find('.progress-category', 0)->find('.description') as $node)
            $timeList[] = $node->text;

        for ($i = 0; $i < count($nameList); ++$i)
            $list[$i] = $nameList[$i] . '-' . $timeList[$i];

        return $list;
    }

    public function getHeroWithRank($rank)
    {
        return self::getHeroesFromGametag($this->gametag)[$rank];
    }

    public static function getHeroWithRankFromGametag($rank, $gametag)
    {
        return self::getHeroesFromGametag($gametag)[$rank];
    }

    public function getHeroNameWithRank($rank) {
        return strstr($this->{'hero' . $rank} , '-', true);
    }

    public function getHeroTimeWithRank($rank) {
        return substr(strstr($this->{'hero' . $rank} , '-'), 1);
    }

    public function getHeroIconWithRank($rank) {
        return "https://blzgdapipro-a.akamaihd.net/hero/" . strtolower(strstr($this->{'hero' . $rank} , '-', true)) . "/icon-right-menu.png";
    }
}
