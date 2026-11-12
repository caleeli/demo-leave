<?php

namespace Tests\Unit\Projects\DemoLeave;

use PHPUnit\Framework\TestCase;
use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases\ValidateLeaveRequest;

class ValidateLeaveRequestTest extends TestCase
{
    public function testRejectsInsufficientBalance(): void
    {
        $result = (new ValidateLeaveRequest())->handle([
            'leaveType' => 'personal',
            'startDate' => '2026-03-02',
            'endDate' => '2026-03-06',
            'balances' => ['personal' => 1, 'annual' => 15, 'sick' => 10],
            'holidayDates' => [],
        ]);

        $this->assertFalse($result['validationPassed']);
        $this->assertNotEmpty($result['validationErrors']);
    }

    public function testAcceptsValidRequest(): void
    {
        $result = (new ValidateLeaveRequest())->handle([
            'leaveType' => 'annual',
            'startDate' => '2026-03-02',
            'endDate' => '2026-03-03',
            'balances' => ['personal' => 3, 'annual' => 15, 'sick' => 10],
            'holidayDates' => [],
        ]);

        $this->assertTrue($result['validationPassed']);
        $this->assertSame('pending_approval', $result['requestStatus']);
        $this->assertSame(2.0, $result['requestedDays']);
    }
}
