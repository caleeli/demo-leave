<?php

namespace ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Domain\Services;

use DateTimeImmutable;

/**
 * Business-day and holiday helpers for leave calculations.
 */
final class LeaveCalendar
{
    /**
     * @param list<string> $holidayDates ISO date strings (Y-m-d)
     */
    public function countBusinessDays(string $startDate, string $endDate, array $holidayDates): int
    {
        $start = new DateTimeImmutable($startDate);
        $end = new DateTimeImmutable($endDate);
        if ($end < $start) {
            return 0;
        }

        $holidayLookup = array_fill_keys($holidayDates, true);
        $days = 0;
        for ($cursor = $start; $cursor <= $end; $cursor = $cursor->modify('+1 day')) {
            $iso = $cursor->format('Y-m-d');
            $weekday = (int) $cursor->format('N');
            if ($weekday >= 6) {
                continue;
            }
            if (isset($holidayLookup[$iso])) {
                continue;
            }
            $days++;
        }

        return $days;
    }

    /**
     * @return list<string>
     */
    public function defaultHolidayCalendar(): array
    {
        return [
            '2026-01-01',
            '2026-01-19',
            '2026-02-16',
            '2026-05-25',
            '2026-07-03',
            '2026-09-07',
            '2026-11-26',
            '2026-11-27',
            '2026-12-25',
        ];
    }
}
