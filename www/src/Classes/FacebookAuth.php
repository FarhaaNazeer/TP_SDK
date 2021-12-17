<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\Interfaces\AuthInterface;
use GuzzleHttp\Client;

class FacebookAuth implements AuthInterface
{

    protected $accessCodeUrl;
    protected $client_id;
    protected $redirect_uri;
    protected $scope = "basic";
    protected $state;

    public function __construct(string $accessCodeUrl, string $client_id, string $redirect_uri, string $scope)
    {
        $this->accessCodeUrl = $accessCodeUrl;
        $this->client_id = $client_id;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    // public function getEndpoint() 
    // {
    //     $client = new Client([
    //         'timeout' => 2.0,
    //         'verify' => true
    //         // 'verify' => __DIR__ . '../../cacert.pem'

    //     ]);
        
    //     // $response = $client->request('GET', 'https://');

    //     return $response;
    // }

    public function generateLoginButton() 
    {
        // $endPoints = $this->getEndpoint();
        $authorizationEndPoint = "https://www.facebook.com/v2.10/dialog/oauth";

        $loginPage = [
            // 'name' => $this->name,
            'loginButton' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}\">Se connecter via $this->name</a>",
            // 'buttonYes' => "<a href=\"{$authorizationEndPoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}\">Oui</a>",
            //'buttonNo' => "<a href=\"http://localhost:80/?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&response_type={$this->response_type}&scope={$this->scope}&access_type={$this->access_type}\">Non</a>"
        ];

      return $loginPage;

    }

    public function getAuthorizationUrl()
    {
    }
    public function getToken()
    {
    }
    public function getUser()
    {
    }
}
