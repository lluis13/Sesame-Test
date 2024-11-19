<?php

declare(strict_types=1);

namespace App\Application;

use DateTimeImmutable;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface EventInterface
{
    public function occurredAt(): DateTimeImmutable;

    public function getType(): string;

    public function getPayload(): array;

}
