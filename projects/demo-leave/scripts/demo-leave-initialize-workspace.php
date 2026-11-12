<?php

/**
 * ProcessMaker script: demo-leave-initialize-workspace
 *
 * Thin wrapper: global $data in, merged process array out.
 * Logic: InitializeLeaveWorkspace.
 */

use ProcessMaker\Package\DemoLeave\Projects\DemoLeave\Application\UseCases\InitializeLeaveWorkspace;

return (new InitializeLeaveWorkspace())->handle($data);
