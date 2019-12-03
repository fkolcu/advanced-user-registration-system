<?php

namespace spec\App\Service;

use App\Service\UserEmailService;
use PhpSpec\ObjectBehavior;

class UserEmailServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserEmailService::class);
    }

    function it_checks_if_email_given_by_user_is_unique()
    {
        $this->isEmailUnique("this_is_unique@email.com")->shouldReturn(true);
    }
}
