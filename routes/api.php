<?php

use ProcessMaker\Package\DemoLeave\Http\Controllers\DemoLeaveController;

Route::group(['middleware' => ['auth:api', 'bindings']], function () {
    Route::get('admin/demo-leave/fetch', [DemoLeaveController::class, 'fetch'])
        ->name('package.skeleton.fetch');
    Route::apiResource('admin/demo-leave', DemoLeaveController::class);
});
