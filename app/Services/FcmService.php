<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected $projectId;
    protected $clientEmail;
    protected $privateKey;
    protected $accessToken;
    protected $tokenExpiry;

    public function __construct()
    {
        $this->projectId = config('syntechfcm.project_id');
        $this->clientEmail = config('syntechfcm.client_email');
        $this->privateKey = config('syntechfcm.private_key');

        // Clean up the private key format
        $this->privateKey = str_replace(['\\n'], ["\n"], $this->privateKey);
    }

    protected function getAccessToken()
    {
        // Check if current access token is still valid
        if ($this->accessToken && $this->tokenExpiry && time() < $this->tokenExpiry - 300) {
            return $this->accessToken;
        }

        try {
            $jwt = $this->createJwt();
            $this->accessToken = $this->exchangeJwtForAccessToken($jwt);
            $this->tokenExpiry = time() + 3300; // 55 minutes to ensure token doesn't expire

            return $this->accessToken;
        } catch (Exception $e) {
            Log::error('FCM Access Token Error: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function createJwt()
    {
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $now = time();
        // Reduce JWT validity to 30 minutes instead of 60
        $expiry = $now + 1800; // 30 minutes

        $payload = [
            'iss' => $this->clientEmail,
            'sub' => $this->clientEmail,
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now - 60, // Add safety margin for time
            'exp' => $expiry,
            'scope' => 'https://www.googleapis.com/auth/cloud-platform',
        ];

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = '';
        $signResult = openssl_sign(
            $base64UrlHeader . "." . $base64UrlPayload,
            $signature,
            $this->privateKey,
            OPENSSL_ALGO_SHA256
        );

        if (!$signResult) {
            throw new Exception('Failed to sign JWT: ' . openssl_error_string());
        }

        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    protected function exchangeJwtForAccessToken($jwt)
    {
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('JWT Exchange Error: ' . $errorBody);
            throw new Exception('Failed to obtain access token: ' . $errorBody);
        }

        $data = $response->json();

        if (isset($data['access_token'])) {
            return $data['access_token'];
        }

        throw new Exception('Failed to obtain access token: ' . json_encode($data));
    }

    protected function base64UrlEncode($data)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    public function sendNotification($title, $body, $token, $image = null, $data = [])
    {
        try {
            $accessToken = $this->getAccessToken();

            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            $message = [
                "message" => [
                    "token" => $token,
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ],
                    "android" => [
                        "priority" => "high",
                        "notification" => [
                            "sound" => "default",
                        ]
                    ],
                    "apns" => [
                        "headers" => [
                            "apns-priority" => "10",
                        ],
                        "payload" => [
                            "aps" => [
                                "sound" => "default",
                                "content-available" => 1,
                            ]
                        ]
                    ]
                ],
            ];

            if ($image) {
                $message["message"]["notification"]["image"] = $image;
                $message["message"]["android"]["notification"]["image"] = $image;
            }

            if (!empty($data)) {
                $message["message"]["data"] = array_map('strval', $data);
            }

            $response = Http::withToken($accessToken)->post($url, $message);

            if (!$response->successful()) {
                Log::error('FCM Send Error: ' . $response->body());
                throw new Exception('Failed to send notification: ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('FCM Service Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function send($data)
    {
        if (!isset($data['to']) || !isset($data['notification'])) {
            throw new Exception('Incomplete notification data');
        }

        $notification = array_merge([
            'title' => '',
            'body' => '',
            'image' => ''
        ], $data['notification']);

        return $this->sendNotification(
            $notification['title'],
            $notification['body'],
            $data['to'],
            $notification['image'],
            $data['data'] ?? []
        );
    }
}
