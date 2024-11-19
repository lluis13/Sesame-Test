<?php

declare(strict_types=1);

namespace App\Application\Exception\WorkEntry;

use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final class WorkEntryNotFoundException extends Exception
{
    public static function becauseDoesNotExists(Uuid $workEntryId): self
    {
        return new self("WorkEntry with id $workEntryId not found");
    }
}
