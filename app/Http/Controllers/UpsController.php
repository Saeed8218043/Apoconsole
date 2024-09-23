<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class UpsController extends Controller
{
    public function fetchUPSApi($inquiryNumber)
    {
        $response = Http::withHeaders([
            'transId' => 'testing',
            'transactionSrc' => 'testing',
            'Content-Type' => 'application/json',
        ])->get("https://wwwcie.ups.com/api/track/v1/details/{$inquiryNumber}?locale=en_US&returnSignature=false");

        // Check if the request was successful
        if ($response->successful()) {
            // API response body
            $data = $response->json();
            return $data;
        } else {
            // Handle error
            $errorCode = $response->status();
            $errorMessage = $response->body();
            // You can log the error or handle it according to your application's logic
            // For now, let's just return a basic error response
            return response()->json(['error' => 'Failed to fetch UPS API', 'code' => $errorCode, 'message' => $errorMessage], $errorCode);
        }
    }
}
