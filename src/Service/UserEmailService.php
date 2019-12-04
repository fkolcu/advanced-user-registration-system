<?php

namespace App\Service;

use App\Infrastructure\Persistence\User\UserRepository;

class UserEmailService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isEmailUnique(string $email): bool
    {
        return null === $this->userRepository->findUserByEmail($email);
    }
}