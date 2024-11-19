<?php

namespace App\Application\Event\User;

use App\Application\EventInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class UserDeletedEvent implements EventInterface
{
    public function __construct(
        public Uuid $userId,
        public DateTimeImmutable $occurredAt = new DateTimeImmutable(),
    ) {}

    public function occurredAt(): DateTimeImmutable
    {
       return $this->occurredAt;
    }

    public function getType(): string
    {
        return __CLASS__;
    }

    public function getPayload(): array
    {
        return [
            'userId'     => $this->userId->toString(),
            'occurredAt' => $this->occurredAt->format('Y-m-d H:i:s'),
            'type'       => $this->getType(),
        ];
    }
}
