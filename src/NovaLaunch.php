<?php

namespace Dnwjn\NovaLaunch;

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Nova;
use Laravel\Nova\Panel;
use Laravel\Nova\Tool;

class NovaLaunch extends Tool
{
    /**
     * Determine if the element should be displayed for the given request.
     *
     * @param Request $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        if (! config('nova-launch.enabled', false) || has_launched()) {
            // Do not authorize since the plugin is not enabled or the site has already been launched.
            return false;
        }

        return parent::authorize($request);
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-launch', __DIR__ . '/../dist/js/tool.js');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View|string
     */
    public function renderNavigation()
    {
        return view('nova-launch::nova.navigation', ['fields' => self::getFields()]);
    }

    /**
     * Get the option fields that should be displayed on the tool page.
     *
     * @return array|Panel[]
     */
    public static function getFields(): array
    {
        $override = config('nova-launch.nova_override_enabled', false);
        if (! $override) {
            return [];
        }

        return [
            new Panel(__('General settings'), function () {
                return [
                    Boolean::make(LaunchKey::BypassEnabled()->description, LaunchKey::BypassEnabled)
                        ->rules(['boolean']),

                    Text::make(LaunchKey::BypassSecret()->description, LaunchKey::BypassSecret)
                        ->rules(['nullable', 'alpha_dash']),
                ];
            }),
        ];
    }

    /**
     * Get the configured event model.
     */
    public static function getEventModel(): string
    {
        return config('nova-launch.classes.event');
    }

    /**
     * Get the configured setting model.
     */
    public static function getSettingModel(): string
    {
        return config('nova-launch.classes.setting');
    }

    /**
     * Get the configured signup model.
     */
    public static function getSignUpModel(): string
    {
        return config('nova-launch.classes.sign_up');
    }

    /**
     * Get the configured user model.
     */
    public static function getUserModel(): string
    {
        return config('nova-launch.classes.user');
    }
}
