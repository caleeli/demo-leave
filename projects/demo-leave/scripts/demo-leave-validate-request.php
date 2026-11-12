<?php

/**
 * ProcessMaker script: demo-leave-validate-request
 *
 * Thin wrapper: global $data in, merged process array out.
 * Logic: ValidateLeaveRequest.
 */

use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases\ValidateLeaveRequest;

return (new ValidateLeaveRequest())->handle($data);
