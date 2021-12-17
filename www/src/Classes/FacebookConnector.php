<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\AbstractClass\AuthConnectorFactory;
use App\Interfaces\AuthInterface;


class FacebookConnector extends AuthConnectorFactory
{
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
        // $this->client_secret = CLIENT_SECRET;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
        $this->access_type = $access_type;
        $this->response_type = $response_type;
    }

    public function getAuthConnector(): AuthInterface
    {
        return new FacebookAuth($this->url, $this->client_id, $this->redirect_uri, $this->scope, $this->access_type, $this->response_type);
    }
}
