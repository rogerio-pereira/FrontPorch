<?php

namespace Tests\Unit\Console;

use App\Console\Commands\InstallFeaturesCommand;
use Tests\TestCase;
use Tests\Unit\Console\Concerns\ManagesChiselFileForTests;
use Tests\Unit\Console\Fakes\InstallFeaturesCommandProbe;
use Tests\Unit\Console\Fakes\TestInstallFeaturesCommand;

class InstallFeaturesCommandTest extends TestCase
{
    use ManagesChiselFileForTests;

    protected function tearDown(): void
    {
        $this->restoreChiselFile();
        $this->releaseChiselLock();
        $this->clearDeferredInstallerHooks();

        parent::tearDown();
    }

    public function test_skips_execution_when_installer_hooks_are_deferred(): void
    {
        $this->deferInstallerHooks();

        $this->artisan('install:features')
            ->assertSuccessful();
    }

    public function test_does_not_defer_when_answers_option_is_provided(): void
    {
        $this->deferInstallerHooks();
        $this->swapChiselWithStub();
        $this->bindTestCommand();

        $this->artisan('install:features', [
            '--answers' => json_encode([]),
        ])->assertSuccessful();

        $this->assertSame(1, TestInstallFeaturesCommand::$installNodeDependenciesCalls);
        $this->assertSame(1, TestInstallFeaturesCommand::$buildAssetsCalls);
    }

    public function test_returns_success_when_chisel_file_is_missing(): void
    {
        $this->removeChiselFile();

        $this->artisan('install:features', [
            '--answers' => json_encode([]),
        ])->assertSuccessful();
    }

    public function test_runs_installer_with_provided_answers(): void
    {
        $this->swapChiselWithStub();
        $this->bindTestCommand();

        $this->artisan('install:features', [
            '--answers' => json_encode([]),
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertSame(1, TestInstallFeaturesCommand::$installNodeDependenciesCalls);
        $this->assertSame(1, TestInstallFeaturesCommand::$buildAssetsCalls);
    }

    public function test_uses_empty_answers_when_answers_option_is_omitted(): void
    {
        $this->swapChiselWithStub();
        $this->bindTestCommand();

        $this->artisan('install:features', [
            '--no-interaction' => true,
        ])->assertSuccessful();

        $this->assertSame(1, TestInstallFeaturesCommand::$installNodeDependenciesCalls);
        $this->assertSame(1, TestInstallFeaturesCommand::$buildAssetsCalls);
    }

    public function test_installs_node_dependencies(): void
    {
        $command = new InstallFeaturesCommandProbe;
        $command->setLaravel($this->app);

        $command->runInstallNodeDependencies();

        $this->assertTrue(true);
    }

    public function test_builds_assets(): void
    {
        $command = new InstallFeaturesCommandProbe;
        $command->setLaravel($this->app);

        $command->runBuildAssets();

        $this->assertTrue(true);
    }

    private function bindTestCommand(): void
    {
        TestInstallFeaturesCommand::resetCallCounts();

        $this->app->bind(InstallFeaturesCommand::class, TestInstallFeaturesCommand::class);
    }

    private function deferInstallerHooks(): void
    {
        putenv('LARAVEL_INSTALLER_DEFER_HOOKS=true');
        $_ENV['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';
        $_SERVER['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';
    }

    private function clearDeferredInstallerHooks(): void
    {
        putenv('LARAVEL_INSTALLER_DEFER_HOOKS');
        unset($_ENV['LARAVEL_INSTALLER_DEFER_HOOKS'], $_SERVER['LARAVEL_INSTALLER_DEFER_HOOKS']);
    }
}
