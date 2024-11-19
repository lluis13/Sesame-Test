<?php

namespace App\Application\Event\WorkEntry;


use App\Application\EventInterface;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
final readonly class WorkEntryUpdatedEvent implements EventInterface
{

    public function __construct(
        public Uuid $workEntryId,
        public ?DateTimeImmutable $startDate,
        public ?DateTimeImmutable $endDate,
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
            'startDate' => $this->startDate ? $this->startDate->format('Y-m-d H:i:s') : null,
            'endDate' => $this->endDate ? $this->endDate->format('Y-m-d H:i:s') : null,
            'occurredAt' => $this->occurredAt->format('Y-m-d H:i:s'),
            'type' => $this->getType(),
        ];
    }
}
