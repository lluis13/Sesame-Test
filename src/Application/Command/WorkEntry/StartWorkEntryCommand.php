<?php

namespace App\Application\Command\WorkEntry;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class StartWorkEntryCommand
{
    public function __construct(
        public string $userUuid,
    ) {}
}
