<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use Webmozart\Assert\Assert;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final class Email
{
    private string $email;

    public function __construct(string $email)
    {
        Assert::email($email, 'Invalid email format');
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string {
        return $this->email;
    }
}
