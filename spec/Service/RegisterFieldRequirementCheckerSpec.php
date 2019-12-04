<?php

namespace spec\App\Service;

use PhpSpec\ObjectBehavior;
use App\Service\UserEmailService;
use App\Service\RegisterFieldRequirementChecker;

class RegisterFieldRequirementCheckerSpec extends ObjectBehavior
{
    private $user;

    function it_is_initializable()
    {
        $this->shouldHaveType(RegisterFieldRequirementChecker::class);
    }

    function let(UserEmailService $userEmailService)
    {
        $this->user = new \stdClass();
        $this->beConstructedWith($userEmailService);
    }

    function it_should_return_string_error_message_if_email_or_password_missing()
    {
        $this->user->email = "test@example.com";
        $this->check($this->user)->shouldReturn("Invalid or missing request arguments.");
    }

    function it_should_return_string_error_message_if_password_is_not_digit()
    {
        $this->user->email = "test@example.com";
        $this->user->password = "non-digit";
        $this->check($this->user)->shouldReturn("User password should only contain digit.");
    }

    function it_should_return_string_error_message_if_password_length_lower_than_6()
    {
        $this->user->email = "test@example.com";
        $this->user->password = "123";
        $this->check($this->user)->shouldReturn("User password length should be minimum 6 digit.");
    }

    function it_should_return_string_error_message_if_email_is_not_valid(UserEmailService $userEmailService)
    {
        $userEmailService->isEmailUnique("not-unique@email.com")->willReturn(false);
        $this->beConstructedWith($userEmailService);

        $this->user->email = "not-unique@email.com";
        $this->user->password = "123456";
        $this->check($this->user)->shouldReturn("This email is already in use.");
    }

    function it_should_return_true_if_all_fields_sent_correctly(UserEmailService $userEmailService)
    {
        $userEmailService->isEmailUnique("new@email.com")->willReturn(true);
        $this->beConstructedWith($userEmailService);

        $this->user->email = "new@email.com";
        $this->user->password = "123456";
        $this->check($this->user)->shouldReturn(true);
    }
}