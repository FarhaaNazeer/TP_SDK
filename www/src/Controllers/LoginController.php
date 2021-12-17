<?php

namespace App\Controllers;

use App\Classes\FacebookConnector;
use App\Classes\GoogleConnector;
use App\Classes\SlackConnector;

// require 'App\Classes\ConnectorClass\GoogleConnector';

class LoginController
{
        public function login()
        {

                $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
                $dotenv->load();

                # GOOGLE AUTH
                $googleAuth = new GoogleConnector($_ENV['GOOGLE_AUTHORIZATION_URL'], $_ENV['GOOGLE_CLIENT_ID'], $_ENV['GOOGLE_REDIRECT_URI'], 'email', 'online', 'code');
                $view = $googleAuth->login();

                echo $view['loginButton'];
                echo '<br>';
                echo $view['buttonYes'];
                echo $view['buttonNo'];
                echo '<br><br>';

                # FB AUTH
                $fbAuth = new FacebookConnector($_ENV['FACEBOOK_CLIENT_ID'], $_ENV['FACEBOOK_REDIRECT_URI'], 'public_profile,email');

                $view = $fbAuth->login();
                echo $view['loginButton'];
                echo '<br>';
                echo $view['buttonYes'];
                echo $view['buttonNo'];
                echo '<br><br>';


                # SLACK AUTH
                $slackAuth = new SlackConnector($_ENV['SLACK_CLIENT_ID'], $_ENV['SLACK_REDIRECT_URI'], 'team:read');
                $view = $slackAuth->login();

                echo $view['loginButton'];
                echo '<br>';
                echo $view['buttonYes'];
                echo $view['buttonNo'];
        }

        public function handleSuccess()
        {
                $uri = $_SERVER['REDIRECT_URL'];
                $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
                $dotenv->load();
                if ($uri === '/redirect_google') {
                        # GOOGLE AUTH
                        $googleAuth = new GoogleConnector($_ENV['GOOGLE_AUTHORIZATION_URL'], $_ENV['GOOGLE_CLIENT_ID'], $_ENV['GOOGLE_REDIRECT_URI'], 'email', 'online', 'code');

                        $code = $_GET['code'];
                        $userInfo = $googleAuth->handleSuccess($code);
                } elseif ($uri === '/redirect_facebook') {
                        # FB AUTH
                        $fbAuth = new FacebookConnector($_ENV['FACEBOOK_CLIENT_ID'], $_ENV['FACEBOOK_REDIRECT_URI'], 'public_profile,email');

                        $code = $_GET['code'];
                        $userInfo = $fbAuth->handleSuccess($code);
                } else {
                        #SLACK AUTH
                        $slackAuth = new SlackConnector($_ENV['SLACK_CLIENT_ID'], $_ENV['SLACK_REDIRECT_URI'], 'team:read');

                        $code = $_GET['code'];
                        $userInfo = $slackAuth->handleSuccess($code);
                }

                #FACEBOOK AUTH

                echo '<h1>Success !</h1>';
                echo $userInfo->email;
                dd($userInfo);
        }

        public function handleFailure()
        {
                echo '<h1>Failure !</h1>';
                echo 'Vous avez été redirigé vers notre site';
        }
}
