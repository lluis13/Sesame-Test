<?php

declare(strict_types=1);

namespace App\Domain\Model\Event;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
interface EventRepositoryInterface
{
    public function save(Event $event): void;
}
