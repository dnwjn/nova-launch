<?php

namespace Dnwjn\NovaLaunch\Console;

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Dnwjn\NovaLaunch\NovaLaunch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LaunchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-launch:launch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launch the site';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (! config('nova-launch.enabled', false)) {
            $this->info('nova-launch is not enabled.');

            return;
        }

        if (has_launched()) {
            $this->info(config('app.name') . ' has already been launched.');

            return;
        }

        $this->info('Please authorize this request by entering your email and password.');

        $credentials = [
            'email' => $this->ask('Email'),
            'password' => $this->secret('Password'),
        ];

        if (! Auth::validate($credentials)) {
            $this->error('The entered credentials are invalid.');

            return;
        }

        $user = NovaLaunch::getUserModel()::where('email', $credentials['email'])->get();

        if (! Gate::forUser($user)->allows('viewNova')) {
            $this->error('The given user is not authorized to execute this command.');

            return;
        }

        NovaLaunch::getSettingModel()::findOrFail(LaunchKey::Launched)->update(['value' => true]);

        NovaLaunch::getEventModel()::dispatch();

        $this->info(config('app.name') . ' has been launched!');
    }
}
