<?php

return [

    /**
     * Set to false to completely disable this package.
     */
    'enabled' => env('NOVA_LAUNCH_ENABLED', false),

    /**
     * The configurable classes the package uses.
     */
    'classes' => [

        /**
         * The event that will be dispatched when the site goes live.
         */
        'event' => \Dnwjn\NovaLaunch\Events\SiteLaunched::class,

        /**
         * The setting model that is used to store the settings.
         */
        'setting' => \Dnwjn\NovaLaunch\Models\Setting::class,

        /**
         * The sign up model that is used to store signups.
         */
        'sign_up' => \Dnwjn\NovaLaunch\Models\SignUp::class,

        /**
         * The user model that is used during authorizations.
         */
        'user' => \App\Models\User::class,

    ],

    /**
     * Route related settings that are used in the middleware check.
     */
    'routes' => [

        /**
         * The routes that should be included in the middleware check.
         * Set to '*' to include all routes, or leave empty to disable.
         */
        'included' => ['*'],

        /**
         * The routes that should be excluded from the middleware check.
         * Leave empty to disable.
         */
        'excluded' => ['*admin*', '*nova*'],

        /**
         * The guard that should be used for the visitors routes.
         */
        'guard' => 'web',

    ],

    /**
     * Allow override of below settings in Nova.
     *
     * Note: if this is enabled, all the settings below will be ignored and only configurable in Nova.
     */
    'nova_override_enabled' => env('NOVA_LAUNCH_NOVA_OVERRIDE_ENABLED', false),

    /**
     * Configuration for the bypass functionality.
     *
     * Bypassing is done by visiting <site_url>/launch/<secret>. This will set a cookie with the given secret,
     * which will be checked on each request.
     */
    'bypass' => [

        /**
         * Set to true to enable the bypass functionality.
         */
        'enabled' => env('NOVA_LAUNCH_BYPASS_ENABLED', false),

        /**
         * This secret needs to be used to successfully bypass the middleware.
         */
        'secret' => env('NOVA_LAUNCH_BYPASS_SECRET'),

    ],

];
