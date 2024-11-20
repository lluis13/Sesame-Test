<?php

declare(strict_types=1);

namespace App\Domain\Model\WorkEntry;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;

final class WorkEntryTime
{
    private DateTimeImmutable $startDate;
    private ?DateTimeImmutable $endDate;

    public function __construct(DateTimeImmutable $startDate, ?DateTimeImmutable $endDate = null)
    {
        if ($endDate !== null && $endDate < $startDate) {
            throw new DomainException("The end date cannot be earlier than the start date.");
        }

        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function equals(WorkEntryTime $other): bool
    {
        return $this->startDate == $other->getStartDate() &&
            $this->endDate == $other->getEndDate();
    }

    public function __toString(): string
    {
        return sprintf(
            'WorkEntryTime(startDate=%s, endDate=%s)',
            $this->startDate->format(DateTimeInterface::ATOM),
            $this->endDate?->format(DateTimeInterface::ATOM) ?? 'null'
        );
    }
}
