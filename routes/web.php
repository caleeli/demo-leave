<?php

use ProcessMaker\Package\DemoLeave\Http\Controllers\DemoLeaveController;

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin/demo-leave', [DemoLeaveController::class, 'index'])->name('package.skeleton.index');
    Route::get('demo-leave', [DemoLeaveController::class, 'index'])->name('package.skeleton.tab.index');
});
