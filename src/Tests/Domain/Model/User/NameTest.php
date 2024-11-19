<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\User;

use App\Domain\Model\User\Name;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class NameTest extends TestCase
{
    public function testValidName(): void
    {
        $name = new Name('Lluis');

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('Lluis', $name->getName());
    }

    public function testInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must have at least 2 characters.');

        new Name('J');
    }

    public function testGetName(): void
    {
        $name = new Name('Lluis');

        $this->assertEquals('Lluis', $name->getName());
    }

    public function testToString()
    {
        $name = new Name('Lluis');

        $this->assertEquals('Lluis', (string) $name);
    }
}
