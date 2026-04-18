# Back to Top

Displays a floating circular button that appears when the visitor scrolls past a configurable threshold. Clicking it scrolls smoothly back to the top of the page. Position and scroll threshold are configurable from the admin.

**Features:**
- Configurable position: bottom-right, bottom-left, or bottom-center
- Configurable scroll threshold (100–2000 px)
- Smooth scroll using the native `scrollTo` API
- Passive scroll listener — zero impact on scroll performance
- Ember-coloured button to match the Contensio brand
- Settings hub card in Admin > Settings

---

## Requirements

- Contensio 2.0 or later

---

## Installation

### Composer

```bash
composer require contensio/plugin-back-to-top
```

### Manual

Copy the plugin directory and register the service provider via the admin plugin manager.

No migrations required.

---

## Configuration

Go to **Admin > Settings > Back to Top**.

| Setting | Default | Description |
|---------|---------|-------------|
| Position | Bottom right | Where the button appears: bottom-right, bottom-left, or bottom-center |
| Scroll threshold | 400 px | How far the visitor must scroll before the button appears |

Settings are stored in the core `settings` table (`module = plugin_back_to_top, setting_key = config`).

---

## How it works

The plugin hooks into `contensio/frontend/body-end` to inject the button `<button>` element and a small inline `<script>`. The button is initially `display:none`. The script attaches a passive `scroll` event listener that shows the button with a fade transition once `window.scrollY` exceeds the configured threshold.

Position is applied as inline CSS on the button element, computed from the `BackToTopConfig::positionCss()` helper based on the stored position setting.

---

## Hook reference

| Hook | Description |
|------|-------------|
| `contensio/frontend/body-end` | Injects the button and scroll script |
| `contensio/admin/settings-cards` | Settings hub card |

---

## Database storage

| Column | Value |
|--------|-------|
| `module` | `plugin_back_to_top` |
| `setting_key` | `config` |
| `value` | JSON: `{"position":"bottom-right","threshold":400}` |
