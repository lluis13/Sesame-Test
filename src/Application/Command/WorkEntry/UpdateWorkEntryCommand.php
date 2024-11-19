<?php

namespace App\Application\Command\WorkEntry;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class UpdateWorkEntryCommand
{
    public function __construct(
        public string $workEntryUuid,
        public string $userUuid,
        public \DateTimeImmutable $startDate,
        public \DateTimeImmutable $endDate
    ) {}
}
