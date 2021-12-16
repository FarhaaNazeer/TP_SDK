<?php

use App\AbstractClass\AbstractProvider;
use App\AbstractClass\AbstractSdk;
use App\Interfaces\AuthInterface;
use App\Interfaces\ProviderInterface;

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
