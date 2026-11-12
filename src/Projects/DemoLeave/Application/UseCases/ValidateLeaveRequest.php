<?php

namespace ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases;

use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Domain\Services\LeaveCalendar;

/**
 * Validates leave dates, type, and remaining balance on process $data.
 */
final class ValidateLeaveRequest
{
    public function __construct(private ?LeaveCalendar $calendar = null)
    {
        $this->calendar = $calendar ?? new LeaveCalendar();
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function handle(array $data): array
    {
        $errors = [];
        $leaveType = (string) ($data['leaveType'] ?? '');
        $startDate = (string) ($data['startDate'] ?? '');
        $endDate = (string) ($data['endDate'] ?? '');
        $halfDay = !empty($data['halfDay']);

        if ($leaveType === '') {
            $errors[] = 'Select a leave type.';
        }
        if ($startDate === '' || $endDate === '') {
            $errors[] = 'Start and end dates are required.';
        }

        $holidayDates = $this->resolveHolidays($data);
        $requestedDays = 0;

        if ($startDate !== '' && $endDate !== '') {
            if ($endDate < $startDate) {
                $errors[] = 'End date cannot be before the start date.';
            } else {
                $requestedDays = $this->calendar->countBusinessDays($startDate, $endDate, $holidayDates);
                if ($halfDay && $requestedDays > 0) {
                    $requestedDays = 0.5;
                } elseif ($requestedDays < 1) {
                    $errors[] = 'The selected range has no business days (weekends/holidays only).';
                }
            }
        }

        $balances = $this->normalizeBalances($data);
        if ($leaveType !== '' && $requestedDays > 0) {
            $remaining = (float) ($balances[$leaveType] ?? 0);
            if ($requestedDays > $remaining) {
                $errors[] = sprintf(
                    'Insufficient %s balance (%.1f days requested, %.1f remaining).',
                    $leaveType,
                    $requestedDays,
                    $remaining
                );
            }
        }

        $data['holidayDates'] = $holidayDates;
        $data['requestedDays'] = $requestedDays;
        $data['validationErrors'] = $errors;
        $data['validationPassed'] = $errors === [];
        $data['requestStatus'] = $errors === [] ? 'pending_approval' : 'validation_failed';
        $data['balances'] = $balances;

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return list<string>
     */
    private function resolveHolidays(array $data): array
    {
        if (!empty($data['holidayDates']) && is_array($data['holidayDates'])) {
            return array_values(array_map('strval', $data['holidayDates']));
        }

        return $this->calendar->defaultHolidayCalendar();
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, float>
     */
    private function normalizeBalances(array $data): array
    {
        $defaults = [
            'annual' => 15.0,
            'sick' => 10.0,
            'personal' => 3.0,
        ];
        $incoming = $data['balances'] ?? [];
        if (!is_array($incoming)) {
            $incoming = [];
        }

        foreach ($defaults as $key => $value) {
            if (!isset($incoming[$key])) {
                $incoming[$key] = $value;
            } else {
                $incoming[$key] = (float) $incoming[$key];
            }
        }

        return $incoming;
    }
}
