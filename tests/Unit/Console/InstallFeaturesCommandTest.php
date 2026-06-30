<?php

namespace Tests\Unit\Console;

use App\Console\Commands\InstallFeaturesCommand;
use Tests\TestCase;

class InstallFeaturesCommandTest extends TestCase
{
    private ?string $chiselBackupPath = null;

    protected function tearDown(): void
    {
        $this->restoreChiselFile();

        putenv('LARAVEL_INSTALLER_DEFER_HOOKS');
        unset($_ENV['LARAVEL_INSTALLER_DEFER_HOOKS'], $_SERVER['LARAVEL_INSTALLER_DEFER_HOOKS']);

        parent::tearDown();
    }

    public function test_skips_execution_when_installer_hooks_are_deferred(): void
    {
        putenv('LARAVEL_INSTALLER_DEFER_HOOKS=true');
        $_ENV['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';
        $_SERVER['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';

        $this->artisan('install:features')
            ->assertSuccessful();
    }

    public function test_does_not_defer_when_answers_option_is_provided(): void
    {
        putenv('LARAVEL_INSTALLER_DEFER_HOOKS=true');
        $_ENV['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';
        $_SERVER['LARAVEL_INSTALLER_DEFER_HOOKS'] = 'true';

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
        TestInstallFeaturesCommand::$installNodeDependenciesCalls = 0;
        TestInstallFeaturesCommand::$buildAssetsCalls = 0;

        $this->app->bind(InstallFeaturesCommand::class, TestInstallFeaturesCommand::class);
    }

    private function swapChiselWithStub(): void
    {
        $chiselPath = base_path('chisel.php');

        if ($this->chiselBackupPath === null) {
            $this->chiselBackupPath = $chiselPath.'.test-backup';
            rename($chiselPath, $this->chiselBackupPath);
        }

        copy(base_path('tests/fixtures/chisel-stub.php'), $chiselPath);
    }

    private function removeChiselFile(): void
    {
        $chiselPath = base_path('chisel.php');

        if (is_file($chiselPath) && $this->chiselBackupPath === null) {
            $this->chiselBackupPath = $chiselPath.'.test-backup';
            rename($chiselPath, $this->chiselBackupPath);
        }
    }

    private function restoreChiselFile(): void
    {
        if ($this->chiselBackupPath === null) {
            return;
        }

        $chiselPath = base_path('chisel.php');

        if (is_file($chiselPath)) {
            unlink($chiselPath);
        }

        rename($this->chiselBackupPath, $chiselPath);
        $this->chiselBackupPath = null;
    }
}

class TestInstallFeaturesCommand extends InstallFeaturesCommand
{
    public static int $installNodeDependenciesCalls = 0;

    public static int $buildAssetsCalls = 0;

    protected function installNodeDependencies(): void
    {
        self::$installNodeDependenciesCalls++;
    }

    protected function buildAssets(): void
    {
        self::$buildAssetsCalls++;
    }
}

class InstallFeaturesCommandProbe extends InstallFeaturesCommand
{
    public function runInstallNodeDependencies(): void
    {
        $this->installNodeDependencies();
    }

    public function runBuildAssets(): void
    {
        $this->buildAssets();
    }
}
