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
        'name', 'email', 'password', 'gametag', 'level', 'picture'
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
        $list = [];

        foreach ($dom->find('.progress-category', 0)->find('.title') as $node)
            $list[] = $node->text;

        return $list;
    }
}
