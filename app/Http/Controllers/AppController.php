<?php

namespace App\Http\Controllers;

use App\Http\Controllers\InstagramController as Instagram;

class AppController extends Controller
{
    protected $instagram;

    // 2115471913.471da7f.d683b1aea75446ad9544932acd7b1c67
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

    public function getCode()
    {
        // receive OAuth code parameter
        $code = $_GET['code'];

        // check whether the user has granted access
        if (isset($code)) {
            // receive OAuth token object
            $data = $this->instagram->getOAuthToken($code);
            dd($data);
            $username = $data->user->username;
            // store user access token
            $this->instagram->setAccessToken($data);
            // now you have access to all authenticated user methods
            $result = $this->instagram->getUserMedia();
        } else {
            // check whether an error occurred
            if (isset($_GET['error'])) {
                echo 'An error occurred: ' . $_GET['error_description'];
            }
        }
    }
}
