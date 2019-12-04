<?php

namespace App\Service;

class RegisterFieldRequirementChecker
{
    /**
     * @var UserEmailService
     */
    private $userEmailService;

    public function __construct(UserEmailService $userEmailService)
    {
        $this->userEmailService = $userEmailService;
    }

    /**
     * Checks all requirements for user registration
     * If check operation is failed, returns string message
     * else return bool as true
     * @param array|object $user
     * @return bool|string
     */
    public function check($user)
    {
        if (!key_exists("email", $user) || !key_exists("password", $user))
            return "Invalid or missing request arguments.";

        if (!is_numeric($user->password))
            return "User password should only contain digit.";

        if (strlen($user->password) < 6)
            return "User password length should be minimum 6 digit.";

        if (filter_var($user->email, FILTER_VALIDATE_EMAIL) !== $user->email)
            return "Email should be a valid email address.";

        if (!$this->userEmailService->isEmailUnique($user->email))
            return "This email is already in use.";

        return true;
    }
}