<?php

namespace App\Application\Query\WorkEntry;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class GetAllWorkEntriesByUserIdQuery
{
    public function __construct(
        public string $userUuid
    ) {}
}
