<?php

namespace App\AbstractClass;

use App\Interfaces\AuthInterface;

abstract class AuthConnectorFactory
{
    abstract public function getAuthConnector(): AuthInterface;

   public function getAuth() 
   {
         $auth = $this->getAuthConnector();
         return $auth;
   }
    public function connect(): void
    {
    
        // $auth = $this->getAuthConnector();
        // $auth->getAuthorizationCode();
        // $auth->getAccessToken();
        // $auth->getUserInfo();
    }

    public function login()
    {
        $auth = $this->getAuth();
        $loginButton = $auth->generateLoginButton();

        return $loginButton;
    } 
}
