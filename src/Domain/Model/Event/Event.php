<?php

declare(strict_types=1);

namespace App\Domain\Model\Event;

use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class Event
{
    private Uuid $id;
    private string $type;
    private \DateTimeImmutable $occurredAt;
    private ?array $payload;

    public function __construct(
        string $type,
        \DateTimeImmutable $occurredAt,
        ?array $payload = null
    ) {
        $this->id         = Uuid::uuid1();
        $this->type       = $type;
        $this->occurredAt = $occurredAt;
        $this->payload    = $payload;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function payload(): ?array
    {
        return $this->payload;
    }
}
