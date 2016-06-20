<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPHtmlParser\Dom;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'tag',
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

    public function getLevel() {
        $dom = new Dom;
        $dom->loadFromUrl('https://playoverwatch.com/en-us/career/pc/eu/' . $this->getAttribute('tag'));
        return $dom->find('.player-level')[0]->firstChild()->text;
    }
}
