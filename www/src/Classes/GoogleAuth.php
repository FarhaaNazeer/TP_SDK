<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\Interfaces\AuthInterface;
use GuzzleHttp\Client;

class GoogleAuth implements AuthInterface
{
    private $name = "Google";
    private $url;
    private $client_id;
    private $redirect_uri;
    private $scope;
    private $access_type;
    private $response_type;

    public function __construct(string $url, string $client_id, string $redirect_uri, string $scope, string $access_type, string $response_type)
    {
        $this->url = $url;
        $this->client_id = $client_id;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
        $this->access_type = $access_type;
        $this->response_type = $response_type;
    }

    public function getEndpoint() 
    {
        $client = new Client([
            'timeout' => 2.0,
            'verify' => true
        ]);
        
        $response = $client->request('GET', 'https://accounts.google.com/.well-known/openid-configuration');

        return $response;
    }

    public function generateLoginButton() 
    {
        $endPoints = $this->getEndpoint();
        $authorizationEndPoint = json_decode($endPoints->getBody())->authorization_endpoint;

        $loginPage = [
            'name' => $this->name,
            'buttonYes' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}\">Oui</a>",
            'buttonNo' => "<a href=\"http://localhost:80/{$this->redirect_uri}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}\">Non</a>"
        ];

      return $loginPage;

    }

    public function getAuthorizationCode()
    {




    }

    public function getAccessToken()
    {
    }

    public function getUserInfo()
    {
    }
}
