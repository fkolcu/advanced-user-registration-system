<?php

namespace spec\App\Service;

use App\Service\EmailService;
use PhpSpec\ObjectBehavior;

class EmailServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailService::class);
    }

    function it_should_be_send_email_and_return_true()
    {
        $this->send("email@example.com", "You have been registered successfully")->shouldReturn(true);
    }
}
