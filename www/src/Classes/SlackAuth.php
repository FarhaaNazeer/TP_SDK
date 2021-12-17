<?php

namespace App\Classes;

use App\Interfaces\AuthInterface;
use GuzzleHttp\Client;

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
        $client = new Client([
            'timeout' => 2.0,
            'verify' => true
            // 'verify' => __DIR__ . '../../cacert.pem'

        ]);

        $tokenEndPoint = 'https://slack.com/api/oauth.access?';

        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        try {
            $response = $client->request('GET', $tokenEndPoint, [
                'form_params' => [
                    'client_id' => $_ENV['SLACK_CLIENT_ID'],
                    'client_secret' => $_ENV['SLACK_CLIENT_SECRET'],
                    'redirect_uri' => $_ENV['SLACK_REDIRECT_URI'],
                    'code' => $code,
                ]
            ]);
        } catch (GuzzleException\ClientException $e) {

            echo $e->getMessage();
        }

        dd(json_decode($response->getBody()));
    }

    public function getUserInfo(string $accessToken)
    {
    }
}
