<?php

declare(strict_types=1);

namespace App\Tests\Domain\Model\WorkEntry;

use App\Domain\Model\WorkEntry\WorkEntryTime;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use DomainException;

/**
 * @author Lluís Puig Ferrer <lluis_96_13@hotmail.com>
 */
class WorkEntryTimeTest extends TestCase
{
    public function testValidWorkEntryTimeWithoutEndDate(): void
    {
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $workEntryTime = new WorkEntryTime($startDate);

        $this->assertInstanceOf(WorkEntryTime::class, $workEntryTime);
        $this->assertSame($startDate, $workEntryTime->getStartDate());
        $this->assertNull($workEntryTime->getEndDate());
    }

    public function testValidWorkEntryTimeWithEndDate(): void
    {
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate = new DateTimeImmutable('2024-11-20 17:00:00');
        $workEntryTime = new WorkEntryTime($startDate, $endDate);

        $this->assertSame($startDate, $workEntryTime->getStartDate());
        $this->assertSame($endDate, $workEntryTime->getEndDate());
    }

    public function testInvalidWorkEntryTimeBecauseEndDateEarlierThanStartDate(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('The end date cannot be earlier than the start date.');

        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate = new DateTimeImmutable('2024-11-19 17:00:00');
        new WorkEntryTime($startDate, $endDate);
    }

    public function testEquals(): void
    {
        $startDate1 = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate1 = new DateTimeImmutable('2024-11-20 17:00:00');
        $workEntryTime1 = new WorkEntryTime($startDate1, $endDate1);

        $startDate2 = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate2 = new DateTimeImmutable('2024-11-20 17:00:00');
        $workEntryTime2 = new WorkEntryTime($startDate2, $endDate2);

        $this->assertTrue($workEntryTime1->equals($workEntryTime2));

        $startDate3 = new DateTimeImmutable('2024-11-20 10:00:00');
        $workEntryTime3 = new WorkEntryTime($startDate3, $endDate1);
        $this->assertFalse($workEntryTime1->equals($workEntryTime3));

        $workEntryTime4 = new WorkEntryTime($startDate1, new DateTimeImmutable('2024-11-20 18:00:00'));
        $this->assertFalse($workEntryTime1->equals($workEntryTime4));
    }

    public function testToString(): void
    {
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $endDate = new DateTimeImmutable('2024-11-20 17:00:00');
        $workEntryTime = new WorkEntryTime($startDate, $endDate);

        $this->assertSame(
            'WorkEntryTime(startDate=2024-11-20T09:00:00+00:00, endDate=2024-11-20T17:00:00+00:00)',
            $workEntryTime->__toString()
        );
    }

    public function testToStringWithoutEndDate(): void
    {
        $startDate = new DateTimeImmutable('2024-11-20 09:00:00');
        $workEntryTime = new WorkEntryTime($startDate);

        $this->assertSame(
            'WorkEntryTime(startDate=2024-11-20T09:00:00+00:00, endDate=null)',
            $workEntryTime->__toString()
        );
    }
}
