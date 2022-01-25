<?php

namespace App\Tests\Domain\Reservation;

use App\Domain\Reservation\ReservationDisabledDays;
use App\Entity\Reservation;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class ReservationDisabledDaysTest extends TestCase
{
    public function testDisabledDates(): void
    {
        $startDate = $this->createDate('2022-01-01');
        $endDate = $this->createDate('2022-01-04');

        $reservation = new Reservation();
        $reservation->setStartTime($startDate);
        $reservation->setEndTime($endDate);

        $reservationDisabledDays = new ReservationDisabledDays();
        self::assertSame(['2022-01-01', '2022-01-02', '2022-01-03'], $reservationDisabledDays->getDisabledDates($reservation));
    }

    private function createDate(string $date): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            "{$date}T12:00:00.000+00:00"
        );
    }
}