<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\WorkEntry;

use App\Domain\Model\User\Email;
use App\Domain\Model\User\Name;
use App\Domain\Model\User\Password;
use App\Domain\Model\User\User;
use App\Domain\Model\WorkEntry\WorkEntry;
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
        $workEntry = new WorkEntry($uuid, $user);

        $this->assertInstanceOf(WorkEntry::class, $workEntry);
        $this->assertSame($uuid, $workEntry->id());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->startDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
        $this->assertNull($workEntry->endDate());
        $this->assertNull($workEntry->deletedAt());
    }

    public function testUpdate(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $workEntry = new WorkEntry($uuid, $user);

        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate = new DateTimeImmutable('2024-11-20 17:00:00');

        $workEntry->update($startDate, $endDate);

        $this->assertSame($startDate, $workEntry->startDate());
        $this->assertSame($endDate, $workEntry->endDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
    }

    public function testDelete(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $workEntry = new WorkEntry($uuid, $user);

        $workEntry->delete();

        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->deletedAt());
    }

    public function testEnd(): void
    {
        $user = $this->createUser();
        $uuid = Uuid::uuid1();
        $workEntry = new WorkEntry($uuid, $user);

        $workEntry->end();

        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->endDate());
        $this->assertInstanceOf(DateTimeImmutable::class, $workEntry->updatedAt());
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
