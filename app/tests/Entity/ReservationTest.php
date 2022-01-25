<?php

namespace App\Tests\Entity;

use App\Entity\Reservation;
use App\Entity\Yacht;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    /**
     * @dataProvider totalPriceDataset
     */
    public function testTotalPrice(string $beginDate, int $days, int $pricePerDay, int $expectedTotalPrice): void
    {
        $startDate = $this->createDate($beginDate);
        $endDate = $startDate->modify("+{$days} days");

        $yacht = new Yacht();
        $yacht->setPricePerDay($pricePerDay);

        $reservation = new Reservation();
        $reservation->setYacht($yacht);
        $reservation->setStartTime($startDate);
        $reservation->setEndTime($endDate);

        self::assertSame($days, $reservation->getDays());
        self::assertSame($expectedTotalPrice, $reservation->getTotalPrice());
    }

    public function totalPriceDataset(): iterable
    {
        yield [
            'beginDate' => '2021-01-01',
            'days' => 1,
            'pricePerDay' => 1,
            'expectedTotalPrice' => 1
        ];

        yield [
            'beginDate' => '2021-01-08',
            'days' => 8,
            'pricePerDay' => 100,
            'expectedTotalPrice' => 800
        ];
    }

    private function createDate(string $date): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            DateTimeInterface::RFC3339_EXTENDED,
            "{$date}T12:00:00.000+00:00"
        );
    }
}