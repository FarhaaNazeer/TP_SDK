<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function getAuthorizationCode();
    public function getAccessToken();
    public function getUserInfo();
}
