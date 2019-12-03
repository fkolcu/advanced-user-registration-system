<?php

namespace spec\App\Service;

use PhpSpec\ObjectBehavior;
use App\Service\TokenGeneratorService;

class TokenGeneratorServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TokenGeneratorService::class);
    }

    function it_generates_token_by_user_email()
    {
        $this->generate("email@example.com")->shouldBeString();
    }
}
