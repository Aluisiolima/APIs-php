<?php 

namespace src\http;

class JWT 
{
    private $secret;
    public function __construct() 
    {
        $this->secret = getenv("SECRET_KEY");
    }

    public function generate(array $data = [])
    {
        $header  = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);
        
        $base64UrlHeader  = $this->base64url_encode($header);
        $base64UrlPayload = $this->base64url_encode($payload);

        $signature = $this->signature($base64UrlHeader, $base64UrlPayload);

        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $signature;

        return $jwt;
    }

    public function verify(string $jwt)
    {
        $tokenPartials = explode('.', $jwt);

        if (count($tokenPartials) != 3) return false;

        [$header, $payload, $signature] = $tokenPartials;

        if ($signature !== $this->signature($header, $payload)) return false;

        return $this->base64url_decode($payload);
    }

    public function signature(string $header, string $payload)
    {
        $signature = hash_hmac('sha256', $header . "." . $payload, $this->secret, true);

        return $this->base64url_encode($signature);
    }

    public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function base64url_decode($data)
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat('=', 4 -  $padding);

        $data = strtr($data, '-_', '+/');

        return json_decode(base64_decode($data), true);
    }
}