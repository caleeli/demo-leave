<?php

namespace ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases;

use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Domain\Services\LeaveCalendar;

/**
 * Seeds default balances, holidays, and employee metadata on first touch.
 */
final class InitializeLeaveWorkspace
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
        if (empty($data['balances']) || !is_array($data['balances'])) {
            $data['balances'] = [
                'annual' => 15.0,
                'sick' => 10.0,
                'personal' => 3.0,
            ];
        }

        if (empty($data['holidayDates'])) {
            $data['holidayDates'] = $this->calendar->defaultHolidayCalendar();
        }

        if (empty($data['requestHistory']) || !is_array($data['requestHistory'])) {
            $data['requestHistory'] = [];
        }

        if (empty($data['requestStatus'])) {
            $data['requestStatus'] = 'draft';
        }

        if (empty($data['employeeName'])) {
            $data['employeeName'] = trim(sprintf(
                '%s %s',
                (string) ($data['_request']['user_firstname'] ?? 'Demo'),
                (string) ($data['_request']['user_lastname'] ?? 'Employee')
            ));
        }

        if (empty($data['employeeEmail'])) {
            $data['employeeEmail'] = (string) ($data['_request']['user_email'] ?? 'admin@processmaker.com');
        }

        return $data;
    }
}
