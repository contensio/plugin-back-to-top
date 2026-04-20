<?php

/**
 * Back to Top - Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\BackToTop\Support;

use Contensio\Models\Setting;

/**
 * Reads and writes Back to Top plugin settings.
 * Stored as a single JSON blob:
 *   module = 'plugin_back_to_top', setting_key = 'config'
 */
class BackToTopConfig
{
    /** Available position options and their CSS values. */
    public const POSITIONS = [
        'bottom-right'  => ['bottom' => '1.5rem', 'right' => '1.5rem'],
        'bottom-left'   => ['bottom' => '1.5rem', 'left'  => '1.5rem'],
        'bottom-center' => ['bottom' => '1.5rem', 'left'  => '50%', 'transform' => 'translateX(-50%)'],
    ];

    protected static array $defaults = [
        'position'  => 'bottom-right',  // bottom-right | bottom-left | bottom-center
        'threshold' => 400,             // px scrolled before button appears
    ];

    public static function all(): array
    {
        try {
            $raw = Setting::where('module', 'plugin_back_to_top')
                ->where('setting_key', 'config')
                ->value('value');

            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) {
                    return array_merge(static::$defaults, $decoded);
                }
            }
        } catch (\Throwable) {}

        return static::$defaults;
    }

    public static function save(array $values): void
    {
        $position  = $values['position'] ?? 'bottom-right';
        $threshold = max(100, (int) ($values['threshold'] ?? 400));

        if (! array_key_exists($position, self::POSITIONS)) {
            $position = 'bottom-right';
        }

        Setting::updateOrCreate(
            ['module' => 'plugin_back_to_top', 'setting_key' => 'config'],
            ['value'  => json_encode(compact('position', 'threshold'), JSON_UNESCAPED_SLASHES)]
        );
    }

    /**
     * Return inline CSS properties for the button position.
     */
    public static function positionCss(string $position): string
    {
        $props = self::POSITIONS[$position] ?? self::POSITIONS['bottom-right'];
        return implode(';', array_map(
            fn ($k, $v) => "{$k}:{$v}",
            array_keys($props),
            array_values($props)
        ));
    }
}
