<?php

namespace Dnwjn\NovaLaunch\Tests\Feature;

use Dnwjn\NovaLaunch\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;

/**
 * @internal
 * @coversNothing
 */
class LaunchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // TODO: Create user and give rights to 'viewNova'
    }

    /** @test */
    public function itCanLaunchViaTheCommandLine(): void
    {
        $this->artisan('nova-launch:launch')
            ->expectsOutput('nova-launch is not enabled.')
        ;

//        // Enable config and test again
//        Config::set('nova-launch.enabled', true);
//
//        $this->artisan('nova-launch:launch')
//            ->expectsOutput('Please authorize this request by entering your email and password.');
    }
}
