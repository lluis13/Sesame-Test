<?php

declare(strict_types=1);

namespace App\Application\Exception\User;

use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final class UserNotFoundException extends Exception
{
    public static function becauseDoesNotExists(Uuid $userId): self
    {
        return new self("User with id $userId not found");
    }
}
