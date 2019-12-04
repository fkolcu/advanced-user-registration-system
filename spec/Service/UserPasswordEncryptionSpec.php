<?php

namespace spec\App\Service;

use App\Service\UserPasswordEncryption;
use PhpSpec\ObjectBehavior;

class UserPasswordEncryptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserPasswordEncryption::class);
    }

    function it_should_encrypt_plain_password()
    {
        $this->encrypt("123456")->shouldNotReturn("123456");
    }
}
