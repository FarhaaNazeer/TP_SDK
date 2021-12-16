<?php


namespace App\Controllers;

use App\Classes\GoogleConnector;
// require 'App\Classes\ConnectorClass\GoogleConnector';

class LoginController
{
    public function login()
    {
        
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();


        $googleAuth = new GoogleConnector($_ENV['GOOGLE_AUTHORIZATION_URL'], $_ENV['GOOGLE_CLIENT_ID'] , $_ENV['GOOGLE_REDIRECT_URI'], 'email', 'online', 'code');

        $view = $googleAuth->login();

        echo $view['name'];
        echo $view ['buttonYes'];
        echo $view ['buttonNo'];
        dd($view);
    }
}
