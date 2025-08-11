<?php

namespace SecureApiClient;

class SecureApiClient
{
    protected string $apiKey;
    protected string $apiSecret;
    protected string $baseUrl;

    public function __construct(string $baseUrl, string $apiKey, string $apiSecret)
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    protected function generateNonce(int $length = 32): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    protected function generateSignature(string $nonce, int $timestamp): string
    {
        $data = $this->apiKey . $nonce . $timestamp;
        return hash_hmac('sha256', $data, $this->apiSecret);
    }

   public function request(string $method, string $endpoint, array $payload = [], bool $isMultipart = false)
    {
        $nonce = $this->generateNonce();
        $timestamp = time();
        $signature = $this->generateSignature($nonce, $timestamp);

        // Default headers
        $headers = [
            "X-API-KEY: {$this->apiKey}",
            "X-NONCE: {$nonce}",
            "X-TIMESTAMP: {$timestamp}",
            "X-API-SIGNATURE: {$signature}",
        ];

        // Jika bukan multipart, set content type JSON
        if (!$isMultipart) {
            $headers[] = "Content-Type: application/json";
        }

        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);

            if ($isMultipart) {
                // multipart/form-data (file + data lain)
                // contoh: $payload['photo'] = new CURLFile('/path/to/file.jpg');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            } else {
                // JSON request
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            }
        } elseif (strtoupper($method) === 'GET' && !empty($payload)) {
            $url .= '?' . http_build_query($payload);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);

        return [
            'status' => $info['http_code'],
            'body' => $response,
            'error' => $error,
        ];
    }
}
