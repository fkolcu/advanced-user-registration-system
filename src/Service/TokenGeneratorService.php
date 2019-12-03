<?php

namespace App\Service;

use Firebase\JWT\JWT;

class TokenGeneratorService
{
    private $key = "secret";

    public function generate(string $email): string
    {
        $payload = array(
            "email" => $email,
            "expire" => time() + 3600
        );

        return JWT::encode($payload, $this->key);
    }
}
