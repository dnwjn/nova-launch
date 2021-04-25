<?php

namespace Dnwjn\NovaLaunch\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BypassEnabled()
 * @method static static BypassSecret()
 * @method static static Cookie()
 * @method static static Launched()
 */
final class LaunchKey extends Enum
{
    public const BypassEnabled = 'bypass_enabled';
    public const BypassSecret = 'bypass_secret';
    public const Cookie = 'nova-launch-bypass';
    public const Launched = 'launched';
}
