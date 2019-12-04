<?php

namespace spec\App\Service;

use PhpSpec\ObjectBehavior;
use App\Service\UserEmailService;
use App\Infrastructure\Persistence\User\UserRepository;

class UserEmailServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserEmailService::class);
    }

    function it_should_return_true_if_email_is_unique(UserRepository $userRepository)
    {
        $userRepository->findUserByEmail("email@example.com")
            ->willReturn(null);

        $this->beConstructedWith($userRepository);
        $this->isEmailUnique("email@example.com")->shouldReturn(true);
    }
}