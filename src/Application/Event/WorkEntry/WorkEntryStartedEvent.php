<?php

namespace App\Application\Event\WorkEntry;


use App\Application\EventInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class WorkEntryStartedEvent implements EventInterface
{

    public function __construct(
        public Uuid $workEntryId,
        public Uuid $userId,
        public DateTimeImmutable $startDate,
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
            'workEntryId' => $this->workEntryId->toString(),
            'userId'      => $this->userId->toString(),
            'startDate'   => $this->startDate->format('Y-m-d H:i:s'),
            'occurredAt'  => $this->occurredAt->format('Y-m-d H:i:s'),
            'type'        => $this->getType(),
        ];
    }
}
