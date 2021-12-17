<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\Interfaces\AuthInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GoogleAuth implements AuthInterface
{
    private $name = "Google";
    private $client_id;
    private $redirect_uri;
    private $scope;
    private $access_type;
    private $response_type;

    public function __construct(string $url, string $client_id, string $redirect_uri, string $scope, string $access_type, string $response_type)
    {
        $this->url = $url;
        $this->client_id = $client_id;
        $this->redirect_uri = urlencode($redirect_uri);
        $this->scope = $scope;
        $this->access_type = $access_type;
        $this->response_type = $response_type;
    }

    public function getEndpoint()
    {
        $client = new Client([
            'timeout' => 2.0,
            'verify' => true
            // 'verify' => __DIR__ . '../../cacert.pem'

        ]);

        $response = $client->request('GET', 'https://accounts.google.com/.well-known/openid-configuration');

        return $response;
    }

    public function generateLoginButton()
    {
        $endPoints = $this->getEndpoint();
        $authorizationEndPoint = json_decode($endPoints->getBody())->authorization_endpoint;

        $loginPage = [
            // 'name' => $this->name,
            'loginButton' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}\">Se connecter via $this->name</a>",
            'buttonYes' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}&name={$this->name}\">Oui</a>",
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

        $endPoints = $this->getEndpoint();
        $tokenEndPoint = json_decode($endPoints->getBody())->token_endpoint;

        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        try {
            $response = $client->request('POST', $tokenEndPoint, [
                'form_params' => [
                    'code' => $code,
                    'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
                    'client_secret' => $_ENV['GOOGLE_CLIENT_SECRET'],
                    'redirect_uri' => $_ENV['GOOGLE_REDIRECT_URI'],
                    'grant_type' => 'authorization_code'
                ]
            ]);

            $access_token = json_decode($response->getBody())->access_token;

            return $access_token;
        } catch (GuzzleException\ClientException $e) {
        }
    }

    public function getUserInfo(string $accessToken)
    {
        $client = new Client([
            'timeout' => 2.0,
            'verify' => true
            // 'verify' => __DIR__ . '../../cacert.pem'

        ]);

        $endPoints = $this->getEndpoint();
        $userInfoEndPoint = json_decode($endPoints->getBody())->userinfo_endpoint;

        $response = $client->request('GET', $userInfoEndPoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $response = json_decode($response->getBody());

        if ($response->email_verified === true) {
            session_start();
            $_SESSION['email'] = $response->email;

            header('Location: /login ');
        }

        return $response;
    }
}
