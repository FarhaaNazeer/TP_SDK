<?php

namespace App\Classes;

use App\Interfaces\AuthInterface;

require 'vendor/autoload.php';

class SlackAuth implements AuthInterface
{
    protected $name = 'Slack';
    protected $client_id;
    protected $redirect_uri;
    protected $scope;

    public function __construct(string $client_id, string $redirect_uri, string $scope)
    {
        $this->client_id = $client_id;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    public function generateLoginButton()
    {
        $authorizationEndPoint = "https://slack.com/oauth/authorize";

        $loginPage = [
            'loginButton' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&scope={$this->scope}\">Se connecter via $this->name</a>",
            'buttonYes' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&scope={$this->scope}\">Oui</a>",
            'buttonNo' => "<a href=\"http://localhost/handle-failure\">Non</a>"
        ];

        return $loginPage;
    }

    public function getAuthorizationCode()
    {
    }

    public function getAccessToken(string $code)
    {
    }

    public function getUserInfo(string $accessToken)
    {
    }
}
