<?php

namespace App\Classes;

require 'vendor/autoload.php';

use App\AbstractClass\AuthConnectorFactory;
use App\Interfaces\AuthInterface;


class FacebookConnector extends AuthConnectorFactory
{

    private $client_id;
    private $redirect_uri;
    private $scope;

    public function __construct(string $client_id, string $redirect_uri, string $scope)
    {

        $this->client_id = $client_id;
        $this->redirect_uri = $redirect_uri;
        $this->scope = $scope;
    }

    public function getAuthConnector(): AuthInterface
    {
        return new FacebookAuth($this->client_id, $this->redirect_uri, $this->scope);
    }
}
