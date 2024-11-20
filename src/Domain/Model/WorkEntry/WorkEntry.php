<?php

declare(strict_types=1);

namespace App\Domain\Model\WorkEntry;

use App\Domain\Model\User\User;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class WorkEntry
{
    private Uuid $id;

    private User $user;

    private WorkEntryTime $workEntryTime;

    private DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

    private ?DateTimeImmutable $deletedAt;

    public function __construct(Uuid $uuid, User $user, WorkEntryTime $workEntryTime)
    {
        $this->id            = $uuid;
        $this->user          = $user;
        $this->workEntryTime = $workEntryTime;
        $this->createdAt     = new DateTimeImmutable();
        $this->updatedAt     = new DateTimeImmutable();
        $this->deletedAt     = null;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function workEntryTime(): WorkEntryTime
    {
        return $this->workEntryTime;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function update(WorkEntryTime $workEntryTime): void
    {
        $this->workEntryTime = $workEntryTime;
        $this->updatedAt     = new DateTimeImmutable();
    }

    public function delete(): void
    {
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = new DateTimeImmutable();
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function end(): void
    {
        $endDate             = new DateTimeImmutable();
        $this->workEntryTime = new WorkEntryTime($this->workEntryTime->getStartDate(), $endDate);
        $this->updatedAt     = $endDate;
    }
}
