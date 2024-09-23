<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EbayAuthService
{
    protected $clientID;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->clientID = env('PRODUCTION_CLIENT_ID');
        $this->clientSecret = env('PRODUCTION_CLIENT_SECRET');
        $this->redirectUri = 'https://www.app.apoconsole.com/grant_code_auth';
    }

    /**
     * Get an access token using client credentials.
     *
     * @return array
     * @throws \Exception
     */
    public function getClientCredentialsToken()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->clientID . ':' . $this->clientSecret),
        ])->asForm()->post('https://api.sandbox.ebay.com/identity/v1/oauth2/token', [
            'grant_type' => 'client_credentials',
            'scope' => 'https://api.ebay.com/oauth/api_scope',
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to obtain client credentials token: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get the authorization URL for eBay.
     *
     * @return string
     */
    public function getAuthorizationUrl($scope)
    {
        return "https://auth.sandbox.ebay.com/oauth2/authorize" .
            "?client_id={$this->clientID}" .
            "&response_type=code" .
            "&redirect_uri=" . urlencode($this->redirectUri) .
            "&scope=" . urlencode($scope);
    }


    /**
     * Exchange authorization code for access token.
     *
     * @param string $authorizationCode
     * @return array
     * @throws \Exception
     */
    public function getAccessToken($authorizationCode)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->clientID . ':' . $this->clientSecret),
        ])->asForm()->post('https://api.sandbox.ebay.com/identity/v1/oauth2/token', [
            'grant_type' => 'authorization_code',
            'code' => $authorizationCode,
            'redirect_uri' => $this->redirectUri,
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to obtain access token: ' . $response->body());
        }

        return $response->json();
    }
}
