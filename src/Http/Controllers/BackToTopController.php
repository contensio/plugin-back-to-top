<?php

/**
 * Back to Top - Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\BackToTop\Http\Controllers;

use Contensio\Plugins\BackToTop\Support\BackToTopConfig;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BackToTopController extends Controller
{
    public function edit()
    {
        return view('contensio-back-to-top::admin.settings', [
            'config'    => BackToTopConfig::all(),
            'positions' => array_keys(BackToTopConfig::POSITIONS),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'position'  => ['required', 'string', 'in:' . implode(',', array_keys(BackToTopConfig::POSITIONS))],
            'threshold' => ['required', 'integer', 'min:100', 'max:2000'],
        ]);

        BackToTopConfig::save($request->only('position', 'threshold'));

        return back()->with('success', 'Back to Top settings saved.');
    }
}
