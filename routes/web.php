<?php

use Contensio\Plugins\BackToTop\Http\Controllers\BackToTopController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'contensio.admin'])
    ->prefix('account/settings')
    ->group(function () {
        Route::get('back-to-top',  [BackToTopController::class, 'edit'])  ->name('back-to-top.settings');
        Route::post('back-to-top', [BackToTopController::class, 'update'])->name('back-to-top.settings.update');
    });
