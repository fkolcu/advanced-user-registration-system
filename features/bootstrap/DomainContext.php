<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context
{
    private $user;

    /**
     * @var EmailService
     */
    private $emailService;

    /**
     * @var UserEmailService
     */
    private $userService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TokenGeneratorService
     */
    private $tokenService;

    private $registrationResponse;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(
        EmailService $emailService,
        UserEmailService $userService,
        UserRepository $userRepository,
        TokenGeneratorService $tokenService
    )
    {
        $this->emailService = $emailService;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
    }

    /**
     * @Given there is user information provided by visitor as a table:
     * @param TableNode $table
     */
    public function thereIsUserInformationProvidedByVisitorAsATable(TableNode $table)
    {
        // Get first row of table node
        $user = $table->getIterator()[0];

        $this->user = new stdClass();
        $this->user->email = $user["email"];
        $this->user->password = $user["password"];
    }

    /**
     * @When I submit the form
     */
    public function iSubmitTheForm()
    {
        PHPUnit\Framework\Assert::assertNotNull($this->user);
    }

    /**
     * @Then Email should be a valid email address
     */
    public function emailShouldBeAValidEmailAddress()
    {
        PHPUnit\Framework\Assert::assertSame(
            $this->user->email,
            filter_var($this->user->email, FILTER_VALIDATE_EMAIL)
        );
    }

    /**
     * @Then Email should be a unique email address
     */
    public function emailShouldBeAUniqueEmailAddress()
    {
        $isUnique = $this->userService->isEmailUnique($this->user->email);

        PHPUnit\Framework\Assert::assertTrue($isUnique);
    }

    /**
     * @Then Password should be a minimum :length digit
     * @param int $length
     */
    public function passwordShouldBeAMinimumDigit(int $length)
    {
        PHPUnit\Framework\Assert::assertGreaterThanOrEqual(
            6,
            strlen($length)
        );
    }

    /**
     * @Then Token should be generated by provided user information
     */
    public function tokenShouldBeGeneratedByProvidedUserInformation()
    {
        $token = $this->tokenService->generate($this->user->email);

        PHPUnit\Framework\Assert::assertNotEmpty($token);
    }

    /**
     * @Then All information of the user should be saved to database
     */
    public function allInformationOfTheUserShouldBeSavedToDatabase()
    {
        $this->registrationResponse = $this->userRepository->save($this->user);
    }

    /**
     * @Then System should return user Id and the Token after registration
     */
    public function systemShouldReturnUserIdAndTheTokenAfterRegistration()
    {
        PHPUnit\Framework\Assert::assertTrue(
            key_exists("id", $this->registrationResponse)
            && key_exists("token", $this->registrationResponse)
        );
        PHPUnit\Framework\Assert::assertNotEmpty($this->registrationResponse->id);
        PHPUnit\Framework\Assert::assertNotEmpty($this->registrationResponse->token);
    }

    /**
     * @Then User should receive an e-mail notification that states that user has been successfully registered
     */
    public function userShouldReceiveAnEMailNotificationThatStatesThatUserHasBeenSuccessfullyRegistered()
    {
        $result = $this->emailService->send($this->emailService, "You have been registered successfully");

        PHPUnit\Framework\Assert::assertTrue($result);
    }
}