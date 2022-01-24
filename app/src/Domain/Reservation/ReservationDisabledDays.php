<?php

declare(strict_types=1);

namespace App\Domain\Reservation;

use App\Entity\Reservation;

final class ReservationDisabledDays
{
    /**
     * @return array<string>
     */
    public function getDisabledDates(Reservation $reservation): array
    {
        $disabledReservationDates = [];

        $currentDateTime = $reservation->getStartTime();
        $endDate = $this->toDate($reservation->getEndTime());
        while (($date = $this->toDate($currentDateTime)) !== $endDate) {
            $disabledReservationDates[] = $date;
            $currentDateTime = $currentDateTime->modify('+1 day');
        }

        return $disabledReservationDates;
    }

    private function toDate(\DateTimeInterface $dateTime): string
    {
        return $dateTime->format('Y-m-d');
    }
}
