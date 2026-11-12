<?php

/**
 * ProcessMaker script: demo-leave-apply-decision
 *
 * Thin wrapper: global $data in, merged process array out.
 * Logic: ApplyLeaveDecision.
 */

use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases\ApplyLeaveDecision;

return (new ApplyLeaveDecision())->handle($data);
