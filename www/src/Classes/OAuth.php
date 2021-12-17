<?php

namespace App\AbstractClass;

use App\Interfaces\ProviderInterface;

class SdkConnector
{
    protected $provider;
    protected $client_id;
    protected $redirect_uri;

    public function getProvider();

    public function getAuthorizationUrl()
    {

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $url = self::getAuthUrl($accessCodeUrl, [
                "redirect_uri" => $redirect_uri,
                "client_id" => $client_id,
                "scope" => $scope,
            ]);
        } else {
        }
    }

    public static function getAuthenticationUrl($baseUrl, $params)
    {
        $params = array_merge([
            "state" => STATE,
            "response_type" => "code",
        ], $params);

        return $baseUrl . "?" . http_build_query($params);
    }

    public function createProvider($provider): ProviderInterface
    {


        $provider = $this->getAuthorizationUrl();
    }
}
