<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\User;

use App\Domain\Model\User\Email;
use App\Domain\Model\User\Name;
use App\Domain\Model\User\Password;
use App\Domain\Model\User\User;
use App\Domain\Model\WorkEntry\WorkEntry;
use App\Application\Event\User\UserCreatedEvent;
use App\Application\Event\User\UserUpdatedEvent;
use App\Application\Event\User\UserDeletedEvent;
use App\Application\Event\WorkEntry\WorkEntryStartedEvent;
use App\Application\Event\WorkEntry\WorkEntryEndEvent;
use App\Application\Event\WorkEntry\WorkEntryCreatedEvent;
use App\Application\Event\WorkEntry\WorkEntryDeletedEvent;
use App\Application\Event\WorkEntry\WorkEntryUpdatedEvent;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class UserTest extends TestCase
{

    public function testCreateUser(): void
    {
        $user = $this->createUser();

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Uuid::class, $user->id());
        $this->assertSame('LluisPuig', $user->name()->getName());
        $this->assertSame('lluis@gmail.com', $user->email()->getEmail());
        $this->assertInstanceOf(DateTimeImmutable::class, $user->createdAt());
        $this->assertNull($user->deletedAt());
        $this->assertInstanceOf(UserCreatedEvent::class, $user->getDomainEvents()[0]);
    }

    public function testUpdate(): void
    {
        $user = $this->createUser();
        $newName = new Name('JoeDoe');
        $newEmail = new Email('Joedoe@gmail.com');
        $newPassword = new Password('NewPassword123');

        $user->update($newName, $newEmail, $newPassword);

        $this->assertSame('JoeDoe', $user->name()->getName());
        $this->assertSame('Joedoe@gmail.com', $user->email()->getEmail());
        $this->assertCount(2, $user->getDomainEvents());
        $this->assertInstanceOf(UserCreatedEvent::class, $user->getDomainEvents()[0]);
        $this->assertInstanceOf(UserUpdatedEvent::class, $user->getDomainEvents()[1]);
    }

    public function testDelete(): void
    {
        $user = $this->createUser();

        $user->delete();

        $this->assertInstanceOf(DateTimeImmutable::class, $user->deletedAt());
        $this->assertInstanceOf(UserCreatedEvent::class, $user->getDomainEvents()[0]);
        $this->assertInstanceOf(UserDeletedEvent::class, $user->getDomainEvents()[1]);
    }

    public function testStartWorkEntry(): void
    {
        $user = $this->createUser();

        $workEntryId = Uuid::uuid1();
        $workEntry = new WorkEntry($workEntryId, $user);

        $this->assertEmpty($user->getWorkEntries());
        $user->startWorkEntry($workEntry);

        $workEntries = $user->getWorkEntries();
        $this->assertCount(1, $workEntries);
        $this->assertSame($workEntry, $workEntries->first());

        $events = $user->getDomainEvents();
        $this->assertInstanceOf(UserCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(WorkEntryStartedEvent::class, $events[1]);
    }
    public function testEndWorkEntry(): void
    {
        $user = $this->createUser();

        $workEntryId = Uuid::uuid1();
        $workEntry = new WorkEntry($workEntryId, $user);

        $user->startWorkEntry($workEntry);

        $workEntries = $user->getWorkEntries();
        $this->assertCount(1, $workEntries);
        $this->assertSame($workEntry, $workEntries->first());

        $this->assertNull($workEntry->endDate());

        $user->endWorkEntry($workEntry);

        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->endDate());

        $events = $user->getDomainEvents();
        $this->assertInstanceOf(UserCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(WorkEntryStartedEvent::class, $events[1]);
        $this->assertInstanceOf(WorkEntryEndEvent::class, $events[2]);
    }

    public function testCreateWorkEntry(): void
    {
        $user = $this->createUser();

        $workEntryId = Uuid::uuid1();
        $workEntry = new WorkEntry($workEntryId, $user);

        $this->assertEmpty($user->getWorkEntries());

        $user->createWorkEntry($workEntry);

        $workEntries = $user->getWorkEntries();
        $this->assertCount(1, $workEntries);
        $this->assertSame($workEntry, $workEntries->first());

        $events = $user->getDomainEvents();
        $this->assertInstanceOf(UserCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(WorkEntryCreatedEvent::class, $events[1]);
    }

    public function testDeleteWorkEntry(): void
    {
        $user = $this->createUser();

        $workEntryId = Uuid::uuid1();
        $workEntry = new WorkEntry($workEntryId, $user);

        $user->createWorkEntry($workEntry);

        $this->assertNull($workEntry->deletedAt());
        $this->assertCount(1, $user->getWorkEntries());

        $user->deleteWorkEntry($workEntry);

        $this->assertNotNull($workEntry->deletedAt());

        $events = $user->getDomainEvents();
        $this->assertInstanceOf(UserCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(WorkEntryCreatedEvent::class, $events[1]);
        $this->assertInstanceOf(WorkEntryDeletedEvent::class, $events[2]);
    }

    public function testUpdateWorkEntry(): void
    {
        $user = $this->createUser();

        $workEntryId = Uuid::uuid1();
        $workEntry = new WorkEntry($workEntryId, $user);

        $user->createWorkEntry($workEntry);

        $this->assertCount(1, $user->getWorkEntries());

        $newStartDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $newEndDate = new DateTimeImmutable('2024-11-20 17:00:00');

        $user->updateWorkEntry($workEntry, $newStartDate, $newEndDate);

        $this->assertSame($newStartDate, $workEntry->startDate());
        $this->assertSame($newEndDate, $workEntry->endDate());

        $events = $user->getDomainEvents();
        $this->assertInstanceOf(UserCreatedEvent::class, $events[0]);
        $this->assertInstanceOf(WorkEntryCreatedEvent::class, $events[1]);
        $this->assertInstanceOf(WorkEntryUpdatedEvent::class, $events[2]);
    }



    private function createUser(): User
    {
        return new User(
            new Name('LluisPuig'),
            new Email('lluis@gmail.com'),
            new Password('Password123')
        );
    }
}
