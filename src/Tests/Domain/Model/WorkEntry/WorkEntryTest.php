<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\WorkEntry;

use App\Domain\Model\User\Email;
use App\Domain\Model\User\Name;
use App\Domain\Model\User\Password;
use App\Domain\Model\User\User;
use App\Domain\Model\WorkEntry\WorkEntry;
use App\Domain\Model\WorkEntry\WorkEntryTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class WorkEntryTest extends TestCase
{

    public function testCreateValidWorkEntry(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $workEntryTime = new WorkEntryTime($startDate);
        $workEntry = new WorkEntry($uuid, $user, $workEntryTime);

        $this->assertInstanceOf(WorkEntry::class, $workEntry);
        $this->assertSame($uuid, $workEntry->id());
        $this->assertSame($startDate, $workEntry->workEntryTime()->getStartDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
        $this->assertNull($workEntry->workEntryTime()->getEndDate());
        $this->assertNull($workEntry->deletedAt());
    }

    public function testUpdate(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $workEntryTime = new WorkEntryTime($startDate);
        $workEntry = new WorkEntry($uuid, $user, $workEntryTime);
        $newEndDate = new DateTimeImmutable('2024-11-20 17:00:00');
        $newWorkEntryTime = new WorkEntryTime($startDate, $newEndDate);
        $workEntry->update($newWorkEntryTime);

        $this->assertEquals($startDate, $workEntry->workEntryTime()->getStartDate());
        $this->assertEquals($newEndDate, $workEntry->workEntryTime()->getEndDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
    }

    public function testDelete(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $workEntryTime = new WorkEntryTime($startDate);
        $workEntry = new WorkEntry($uuid, $user, $workEntryTime);

        $workEntry->delete();

        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->deletedAt());
    }

    public function testEnd(): void {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $startDate = new DateTimeImmutable('2024-11-20 07:00:00');
        $workEntryTime = new WorkEntryTime($startDate);
        $workEntry = new WorkEntry($uuid, $user, $workEntryTime);

        $workEntry->end();

        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->workEntryTime()->getEndDate());
        $this->assertSame($workEntry->workEntryTime()->getEndDate(), $workEntry->updatedAt());
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
