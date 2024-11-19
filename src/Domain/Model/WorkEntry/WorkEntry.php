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

    private DateTimeImmutable $startDate;

    private ?DateTimeImmutable $endDate;

    private DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

    private ?DateTimeImmutable $deletedAt;

    public function __construct(Uuid $uuid, User $user)
    {
        $this->id        = $uuid;
        $this->user      = $user;
        $this->startDate = new DateTimeImmutable();
        $this->endDate   = null;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->deletedAt = null;
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function update(
        DateTimeImmutable $startDate,
        ?DateTimeImmutable $endDate
    ): void {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->updatedAt = new DateTimeImmutable();
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
        $this->endDate   = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();

    }
}
