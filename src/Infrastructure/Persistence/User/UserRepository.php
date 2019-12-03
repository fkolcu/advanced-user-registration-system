<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use Doctrine\ORM\EntityManager;

class UserRepository implements \App\Domain\User\UserRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @inheritDoc
     */
    public function findUserOfId(int $id): User
    {
        // TODO: Implement findUserOfId() method.
    }
}