<?php

use App\Domain\User\User;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class DomainContext extends CommonContext
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
     * @Given there is user information provided by visitor as a table:
     * @param TableNode $table
     */
    public function thereIsUserInformationProvidedByVisitorAsATable(TableNode $table)
    {
        // Get first row of table node
        $user = $table->getIterator()[0];
        $this->user = new User($user["email"], $user["password"]);
    }

    /**
     * @When I submit the form
     */
    public function iSubmitTheForm()
    {
        PHPUnit\Framework\Assert::assertNotNull($this->user);
    }
}