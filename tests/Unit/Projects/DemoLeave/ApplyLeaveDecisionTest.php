<?php

namespace Tests\Unit\Projects\DemoLeave;

use PHPUnit\Framework\TestCase;
use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases\ApplyLeaveDecision;

class ApplyLeaveDecisionTest extends TestCase
{
    public function testApprovalDeductsBalance(): void
    {
        $result = (new ApplyLeaveDecision())->handle([
            'managerDecision' => 'approve',
            'requestedDays' => 2,
            'leaveType' => 'annual',
            'startDate' => '2026-04-01',
            'endDate' => '2026-04-02',
            'balances' => ['annual' => 10, 'sick' => 5, 'personal' => 3],
            'employeeName' => 'Alex',
            'employeeEmail' => 'alex@example.com',
        ]);

        $this->assertSame('approved', $result['requestStatus']);
        $this->assertSame(8.0, $result['balances']['annual']);
        $this->assertCount(1, $result['requestHistory']);
    }
}
