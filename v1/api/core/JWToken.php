<?php
include_once __DIR__ . '/../../config/config.php';
class JWToken
{

    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    function generateToken($data, $exp_time = 3600)
    {
        $key = SECRET_KEY_JWT;
        $headers = ['alg' => 'HS256', 'typ' => 'JWT'];
        $headers_encoded = $this->base64url_encode(json_encode($headers));

        $payload = [
            'iss' => 'http://localhost',
            'aud' => 'http://localhost',
            'exp' => time() + $exp_time,
            'data' => $data
        ];
        $payload_encoded = $this->base64url_encode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headers_encoded.$payload_encoded", $key, true);
        $signature_encoded = $this->base64url_encode($signature);

        return "$headers_encoded.$payload_encoded.$signature_encoded";
    }

    function verifyToken($token)
    {
        $key = SECRET_KEY_JWT;
        $token_parts = explode('.', $token);
        $token_header = $token_parts[0];
        $token_payload = $token_parts[1];
        //decoding data
        $header_decoded = json_decode($this->base64url_decode($token_header));
        $payload_decoded = json_decode($this->base64url_decode($token_payload));

        $retorno = false;
        //verifying signature
        if ($header_decoded->alg !== 'HS256') {
            $retorno = false;
        }
        if ($payload_decoded->exp < time()) {
            $retorno = false;
        }
        if (!isset($payload_decoded->data)) {
            $retorno = false;
        }
        if (hash_equals(hash_hmac('sha256', "$token_header.$token_payload", $key, true), $this->base64url_decode($token_parts[2]))) {
            $retorno = $payload_decoded->data;
        }
        return $retorno;
    }
}
