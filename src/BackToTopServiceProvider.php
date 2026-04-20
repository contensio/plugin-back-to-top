<?php

/**
 * Back to Top - Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\BackToTop;

use Contensio\Support\Hook;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BackToTopServiceProvider extends ServiceProvider
{
    protected string $ns = 'contensio-back-to-top';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->ns);

        $this->registerRoutes();

        Hook::add('contensio/admin/settings-cards', function (): string {
            return view($this->ns . '::partials.settings-hub-card')->render();
        });

        Hook::add('contensio/frontend/body-end', function (): string {
            return view($this->ns . '::partials.button')->render();
        });
    }

    private function registerRoutes(): void
    {
        if (! $this->app->routesAreCached()) {
            Route::middleware('web')
                ->group(__DIR__ . '/../routes/web.php');
        }
    }
}
