<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use Webmozart\Assert\Assert;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final class Name
{
    private string $name;

    public function __construct(string $name)
    {
        Assert::minLength($name, 2, 'Name must have at least 2 characters.');

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
