<?php

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Dnwjn\NovaLaunch\NovaLaunch;

if (! function_exists('get_launch_setting')) {
    /**
     * Get the setting for the given key.
     *
     * @param string $key
     * @return string|null
     */
    function get_launch_setting(string $key): ?string
    {
        return NovaLaunch::getSettingModel()::find($key)->value ?? null;
    }
}

if (! function_exists('has_launched')) {
    /**
     * Check if the site has launched.
     *
     * @return bool
     */
    function has_launched(): bool
    {
        return (bool) get_launch_setting(LaunchKey::Launched) === true;
    }
}

if (! function_exists('can_bypass')) {
    /**
     * Check if the user can bypass the middleware.
     *
     * @return bool
     */
    function can_bypass(): bool
    {
        $enabled = config('nova-launch.bypass.enabled', false);
        $secret = config('nova-launch.bypass.secret');

        if (config('nova-launch.nova_override_enabled', false)) {
            $enabled = (bool) get_launch_setting(LaunchKey::BypassEnabled) === true;
            $secret = get_launch_setting(LaunchKey::BypassSecret);
        }

        return $enabled && request()->cookie(LaunchKey::Cookie) === $secret;
    }
}
