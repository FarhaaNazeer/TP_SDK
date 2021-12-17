<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\Interfaces\AuthInterface;
use GuzzleHttp\Client;

class FacebookAuth implements AuthInterface
{

    protected $accessCodeUrl;
    protected $name = 'Facebook';
    protected $client_id;
    protected $redirect_uri;
    protected $scope = "basic";
    protected $state;

    public function __construct(string $client_id, string $redirect_uri, string $scope)
    {
        $this->client_id = $client_id;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }


    public function generateLoginButton()
    {
        $authorizationEndPoint = "https://www.facebook.com/v2.10/dialog/oauth";

        $loginPage = [
            // 'name' => $this->name,
            'loginButton' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&scope={$this->scope}\">Se connecter via $this->name</a>",
            'buttonYes' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&scope={$this->scope}&name={$this->name}\">Oui</a>",
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

        $tokenEndPoint = 'https://graph.facebook.com/v12.0/oauth/access_token?';


        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        try {
            $response = $client->request('GET', $tokenEndPoint, [
                'form_params' => [
                    'client_id' => $_ENV['FACEBOOK_CLIENT_ID'],
                    'redirect_uri' => $_ENV['FACEBOOK_REDIRECT_URI'],
                    'client_secret' => $_ENV['FACEBOOK_CLIENT_SECRET'],
                    'code' => $code,
                ]
            ]);
            dd($response);
            $access_token = json_decode($response->getBody())->access_token;


            return $access_token;
        } catch (GuzzleException\ClientException $e) {
        }
    }
    public function getUserInfo(string $accessToken)
    {
    }
}
