<?php

namespace Dnwjn\NovaLaunch\Tests;

use Dnwjn\NovaLaunch\NovaLaunchServiceProvider;

/**
 * @internal
 * @coversNothing
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaLaunchServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
    }
}
