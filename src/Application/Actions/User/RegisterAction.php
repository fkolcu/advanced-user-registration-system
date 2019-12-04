<?php

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Log\LoggerInterface;
use App\Service\EmailService;
use App\Service\TokenGeneratorService;
use App\Service\UserPasswordEncryption;
use App\Domain\User\UserRepositoryInterface;
use App\Service\RegisterFieldRequirementChecker;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends UserAction
{
    /**
     * @var EmailService
     */
    private $emailService;

    /**
     * @var TokenGeneratorService
     */
    private $tokenGenerator;

    /**
     * @var UserPasswordEncryption
     */
    private $passwordEncryption;

    /**
     * @var RegisterFieldRequirementChecker
     */
    private $fieldRequirementChecker;

    public function __construct(
        LoggerInterface $logger,
        EmailService $emailService,
        TokenGeneratorService $tokenGenerator,
        UserRepositoryInterface $userRepository,
        UserPasswordEncryption $passwordEncryption,
        RegisterFieldRequirementChecker $fieldRequirementChecker
    )
    {
        parent::__construct($logger, $userRepository);
        $this->emailService = $emailService;
        $this->tokenGenerator = $tokenGenerator;
        $this->passwordEncryption = $passwordEncryption;
        $this->fieldRequirementChecker = $fieldRequirementChecker;
    }

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        if ($this->args !== null || $this->args["requestType"] === "html") //html
            $body = (object)$this->request->getParsedBody();
        else //json
            $body = $this->getFormData();

        // Check if required fields are sent correctly
        $check = $this->fieldRequirementChecker->check($body);
        if ($check !== true && is_string($check)) {
            return $this->customRespond(400, null, $check);
        }

        // Encode plain password
        $encodedPassword = $this->passwordEncryption->encrypt($body->password);

        // Generate new token
        $token = $this->tokenGenerator->generate($body->email);

        // New user
        $user = new User();
        $user->setEmail($body->email)
            ->setPassword($encodedPassword)
            ->setToken($token);

        // Save user to database
        $user = $this->userRepository->save($user);

        // Return user id and token after registration
        $response = ["id" => $user->getId(), "token" => $user->getToken()];

        return $this->customRespond(201, $response);
    }
}