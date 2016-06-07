<?php

namespace App\Http\Controllers;

use App\Http\Controllers\InstagramController as Instagram;

class AppController extends Controller
{
    protected $instagram;

    public function __construct()
    {
        $this->instagram = new Instagram([
        'apiKey'      => '471da7fbda13475f940d2e0f8f79344c',
        'apiSecret'   => '650a7b030977472394e9de581b95ed2b',
        'apiCallback' => 'https://instagramtelegrambot.herokuapp.com',
        ]);
    }

    public function OAuth()
    {
       echo "<a href='{$this->instagram->getLoginUrl()}'>Login with Instagram</a>";
    }
}
