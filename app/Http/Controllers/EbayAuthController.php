<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EbayAuthService;

class EbayAuthController extends Controller
{
    protected $ebayAuthService;
    protected $apiBaseUrl = 'https://api.sandbox.ebay.com';

    public function __construct(EbayAuthService $ebayAuthService)
    {
        $this->ebayAuthService = $ebayAuthService;
    }

    /**
     * Redirect to eBay for user authorization.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToEbay($scope, $endpoint)
    {
        session(['endpoint' => $endpoint]);
        $authUrl = $this->ebayAuthService->getAuthorizationUrl($scope);
        return redirect($authUrl);
    }


    public function getInventory()
    {
        $scope = 'https://api.ebay.com/oauth/api_scope/sell.inventory';
        $endpoint = $this->apiBaseUrl . '/sell/inventory/v1/offer?sku=AU1228100';
        return $this->redirectToEbay($scope, $endpoint);
    }

    public function getFulfillment()
    {
        $scope = 'https://api.ebay.com/oauth/api_scope/sell.fulfillment';
        $endpoint = $this->apiBaseUrl . '/sell/fulfillment/v1/order';
        return $this->redirectToEbay($scope, $endpoint);
    }


    /**
     * Handle eBay callback and exchange authorization code for access token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleCallback(Request $request)
    {
        $authorizationCode = $request->input('code');

        try {
            $tokenResponse = $this->ebayAuthService->getAccessToken($authorizationCode);
            // Process the token response, e.g., store the token in the session or database
            return response()->json($tokenResponse);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
