<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\User;

use App\Domain\Model\User\Password;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class PasswordTest extends TestCase
{
    public function testValidPassword(): void
    {
        $password = new Password('Password123');

        $this->assertInstanceOf(Password::class, $password);
        $this->assertEquals('Password123', $password->getPassword());
    }

    public function testInvalidPasswordBecauseLength(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must have at least 8 characters");

        new Password('a');
    }

    public function testInvalidPasswordBecauseNotHaveLetters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must have at least one letter");

        new Password('12345678');
    }

    public function testInvalidPasswordBecauseNotHaveNumbers(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Password must have at least one number");

        new Password('password');
    }

    public function testGetPassword(): void
    {
        $password = new Password('Password123');

        $this->assertEquals('Password123', $password->getPassword());
    }

    public function testToString(): void
    {
        $password = new Password('Password123');

        $this->assertEquals('Password123', (string) $password);
    }
}
