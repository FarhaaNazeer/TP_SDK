<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function getAuthorizationCode();
    public function getAccessToken(string $code);
    public function getUserInfo(string $accessToken);
}
