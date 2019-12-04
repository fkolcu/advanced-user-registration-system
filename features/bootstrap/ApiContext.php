<?php

use App\Domain\User\User;

/**
 * Defines application features from the specific context.
 */
class ApiContext extends CommonContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Given there is user information provided as json :jsonUser
     * @param string $jsonUser
     */
    public function thereIsUserInformationProvidedAsJson(string $jsonUser)
    {
        $user = json_decode($jsonUser);
        $this->user = new User($user->email, $user->password);
    }

    /**
     * @Then I send a request to registration action
     */
    public function iSendARequestToRegistrationAction()
    {
        PHPUnit\Framework\Assert::assertNotNull($this->user);
    }
}