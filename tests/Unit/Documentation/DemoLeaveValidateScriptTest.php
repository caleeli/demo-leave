<?php

namespace Tests\Unit\Documentation;

use PHPUnit\Framework\TestCase;

class DemoLeaveValidateScriptTest extends TestCase
{
    public function testValidateScriptWrapper(): void
    {
        global $data;
        $data = [
            'leaveType' => 'sick',
            'startDate' => '2026-05-04',
            'endDate' => '2026-05-04',
            'balances' => ['annual' => 15, 'sick' => 10, 'personal' => 3],
        ];

        $result = include dirname(__DIR__, 3) . '/projects/demo-leave/scripts/demo-leave-validate-request.php';

        $this->assertTrue($result['validationPassed']);
        $this->assertSame(1.0, $result['requestedDays']);
    }
}
