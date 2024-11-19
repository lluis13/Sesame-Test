<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use App\Application\Event\User\UserCreatedEvent;
use App\Application\Event\User\UserDeletedEvent;
use App\Application\Event\User\UserUpdatedEvent;
use App\Application\Event\WorkEntry\WorkEntryCreatedEvent;
use App\Application\Event\WorkEntry\WorkEntryDeletedEvent;
use App\Application\Event\WorkEntry\WorkEntryEndEvent;
use App\Application\Event\WorkEntry\WorkEntryStartedEvent;
use App\Application\Event\WorkEntry\WorkEntryUpdatedEvent;
use App\Application\EventInterface;
use App\Domain\Model\WorkEntry\WorkEntry;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private Uuid $id;

    private Name $name;

    private Email $email;

    private Password $password;

    private DateTimeImmutable $createdAt;

    private DateTimeImmutable $updatedAt;

    private ?DateTimeImmutable $deletedAt;

    private Collection $workEntries;

    private array $domainEvents = [];

    public function __construct(Name $name, Email $email, Password $password)
    {
        $this->id          = Uuid::uuid1();
        $this->name        = $name;
        $this->email       = $email;
        $this->password    = $password;
        $this->createdAt   = new DateTimeImmutable();
        $this->updatedAt   = new DateTimeImmutable();
        $this->deletedAt   = null;
        $this->workEntries = new ArrayCollection();

        $this->recordEvent(new UserCreatedEvent($this->id));
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function deletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function update(
        Name $name,
        Email $email,
        Password $password,
    ): void {
        $this->name      = $name;
        $this->email     = $email;
        $this->password  = $password;
        $this->updatedAt = new DateTimeImmutable();

        $this->recordEvent(new UserUpdatedEvent(
                $this->id,
                $this->name->getName(),
                $this->email->getEmail(),
                $this->password->getPassword(),
            ),
        );
    }

    public function delete(): void
    {
        $this->deletedAt = new DateTimeImmutable();

        $this->recordEvent(
            new UserDeletedEvent(
                $this->id,
            ),
        );
    }

    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return ($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getEmail();
    }

    public function getPassword(): ?string
    {
        return $this->password->getPassword();
    }

    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }

    public function startWorkEntry(WorkEntry $workEntry): void
    {
        $workEntry->update($workEntry->startDate(), $workEntry->endDate());

        $this->getWorkEntries()->add($workEntry);

        $this->recordEvent(new WorkEntryStartedEvent(
                $workEntry->id(),
                $this->id(),
                $workEntry->startDate(),
            ),
        );
    }

    public function endWorkEntry(WorkEntry $workEntry): void
    {
        /** @var WorkEntry $entry */
        foreach ($this->getWorkEntries() as $entry) {
            if ($entry->id()->equals($workEntry->id())) {
                $entry->end();

                $this->recordEvent(new WorkEntryEndEvent($workEntry->id()));

                break;
            }
        }
    }

    public function createWorkEntry(WorkEntry $workEntry): void
    {
        $this->getWorkEntries()->add($workEntry);

        $this->recordEvent(new WorkEntryCreatedEvent(
                $workEntry->id(),
                $this->id(),
                $workEntry->startDate(),
            ),
        );
    }

    public function deleteWorkEntry(WorkEntry $workEntry): void
    {
        /** @var WorkEntry $entry */
        foreach ($this->getWorkEntries() as $entry) {
            if ($entry->id()->equals($workEntry->id())) {
                $workEntry->delete();

                $this->recordEvent(new WorkEntryDeletedEvent($workEntry->id()));

                break;
            }
        }
    }

    public function updateWorkEntry(
        WorkEntry $workEntry,
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
    ): void {
        /** @var WorkEntry $entry */
        foreach ($this->getWorkEntries() as $entry) {
            if ($entry->id()->equals($workEntry->id())) {
                $entry->update($startDate, $endDate);

                $this->recordEvent(new WorkEntryUpdatedEvent(
                        $workEntry->id(),
                        $startDate,
                        $endDate,
                    ),
                );

                break;
            }
        }
    }

    private function recordEvent(EventInterface $param): void
    {
        $this->domainEvents[] = $param;
    }

    public function getWorkEntries(): Collection
    {
        return $this->workEntries;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
