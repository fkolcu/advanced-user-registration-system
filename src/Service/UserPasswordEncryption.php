<?php

namespace App\Service;

class UserPasswordEncryption
{
    /**
     * @var array
     */
    private $options;

    public function __construct()
    {
        $this->options = ['cost' => 12];
    }

    /**
     * Encrypts given plain password
     * @param string $password
     * @return string
     */
    public function encrypt(string $password): string
    {
        return password_hash(
            $password,
            PASSWORD_BCRYPT,
            $this->options
        );
    }
}