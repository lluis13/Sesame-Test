<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use Webmozart\Assert\Assert;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final class Password
{
    private string $password;

    public function __construct(string $password)
    {
        Assert::minLength($password, 8, "Password must have at least 8 characters");
        Assert::regex($password, '/[a-zA-Z]/', "Password must have at least one letter");
        Assert::regex($password, '/[0-9]/', "Password must have at least one number");

        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
