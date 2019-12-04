<?php

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Service\TokenGeneratorService;
use App\Service\UserPasswordEncryption;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class UserRepository
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var UserPasswordEncryption
     */
    private $encryption;

    public function __construct(
        Manager $manager,
        UserPasswordEncryption $encryption
    )
    {
        $this->manager = $manager;
        $this->encryption = $encryption;
    }

    /**
     * Inserts user to database
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        // Encrypt password
        $hashedPassword = $this->encryption->encrypt($user->getPassword());

        // Get user table and insert user to db
        $table = $this->manager::table("user");

        $id = $table->insertGetId([
            "email" => $user->getEmail(),
            "password" => $hashedPassword,
            "token" => $user->getToken()
        ]);

        $user->setId($id);

        return $user;
    }

    /**
     * @param string $email
     * @return Model|Builder|object|null
     */
    public function findUserByEmail(string $email)
    {
        $table = $this->manager::table("user");
        $found = $table->where("email", "=", $email);
        return $found->first();
    }
}