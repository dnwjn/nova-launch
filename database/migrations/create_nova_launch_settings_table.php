<?php

use Dnwjn\NovaLaunch\Enums\LaunchKey;
use Dnwjn\NovaLaunch\NovaLaunch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovaLaunchSettingsTable extends Migration
{
    protected function getLaunchSettings(): array
    {
        return [
            LaunchKey::BypassEnabled => 0,
            LaunchKey::BypassSecret => null,
            LaunchKey::Launched => 0,
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nova_launch_settings', function (Blueprint $table) {
            $table->string('key')->unique()->primary();
            $table->string('value')->nullable();
        });

        foreach ($this->getLaunchSettings() as $key => $value) {
            NovaLaunch::getSettingModel()::firstOrCreate(compact('key', 'value'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nova_launch_settings');
    }
}
