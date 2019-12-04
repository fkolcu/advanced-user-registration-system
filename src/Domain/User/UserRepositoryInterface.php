<?php
declare(strict_types=1);

namespace App\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user): User;

    /**
     * @param string $email
     * @return mixed
     */
    public function findUserByEmail(string $email);
}