<?php

use App\Domain\User\User;
use App\Service\EmailService;
use Behat\Behat\Context\Context;
use App\Service\UserEmailService;
use App\Service\TokenGeneratorService;
use App\Application\Utility\ContainerInjection;
use App\Infrastructure\Persistence\User\UserRepository;

class CommonContext implements Context
{
    use ContainerInjection;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserEmailService|mixed
     */
    protected $userService;

    /**
     * @var TokenGeneratorService|mixed
     */
    protected $tokenService;

    /**
     * @var EmailService|mixed
     */
    protected $emailService;

    /**
     * @var UserRepository|mixed
     */
    protected $userRepository;

    /**
     * @var User
     */
    protected $registrationResponse;

    public function __construct()
    {
        $container = $this->getContainer();
        $this->emailService = $container->get(EmailService::class);
        $this->userService = $container->get(UserEmailService::class);
        $this->tokenService = $container->get(TokenGeneratorService::class);
        $this->userRepository = $container->get(UserRepository::class);
    }

    /**
     * @Then Email should be a valid email address
     */
    public function emailShouldBeAValidEmailAddress()
    {
        PHPUnit\Framework\Assert::assertSame(
            $this->user->getEmail(),
            filter_var($this->user->getEmail(), FILTER_VALIDATE_EMAIL)
        );
    }

    /**
     * @Then Email should be a unique email address
     */
    public function emailShouldBeAUniqueEmailAddress()
    {
        $isUnique = $this->userService->isEmailUnique($this->user->getEmail());

        PHPUnit\Framework\Assert::assertTrue($isUnique);
    }

    /**
     * @Then Password should be a minimum :length digit
     * @param int $length
     */
    public function passwordShouldBeAMinimumDigit(int $length)
    {
        PHPUnit\Framework\Assert::assertIsNumeric($this->user->getPassword());
        PHPUnit\Framework\Assert::assertGreaterThanOrEqual(
            $length,
            strlen($this->user->getPassword())
        );
    }

    /**
     * @Then Token should be generated by provided user information
     */
    public function tokenShouldBeGeneratedByProvidedUserInformation()
    {
        $token = $this->tokenService->generate($this->user->getEmail());

        PHPUnit\Framework\Assert::assertNotEmpty($token);

        $this->user->setToken($token);
    }

    /**
     * @Then All information of the user should be saved to database
     */
    public function allInformationOfTheUserShouldBeSavedToDatabase()
    {
        $this->registrationResponse = $this->userRepository->save($this->user);
    }

    /**
     * @Then User should receive an e-mail notification that states that user has been successfully registered
     */
    public function userShouldReceiveAnEMailNotificationThatStatesThatUserHasBeenSuccessfullyRegistered()
    {
        $result = $this->emailService->send($this->user->getEmail(), "You have been registered successfully");

        PHPUnit\Framework\Assert::assertTrue($result);
    }

    /**
     * @Then System should return user Id and the Token after registration
     */
    public function systemShouldReturnUserIdAndTheTokenAfterRegistration()
    {
        PHPUnit\Framework\Assert::assertNotEmpty($this->registrationResponse->getId());
        PHPUnit\Framework\Assert::assertNotEmpty($this->registrationResponse->getToken());
    }
}