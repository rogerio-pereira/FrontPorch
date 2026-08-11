<?php

namespace Tests\Unit\Console\Commands\InstallFeaturesCommand\Concerns;

use App\Console\Commands\InstallFeaturesCommand;
use Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes\TestInstallFeaturesCommand;

trait ManagesChiselFileForTests
{
    private ?string $chiselBackupPath = null;

    /** @var resource|null */
    private static $chiselLockHandle = null;

    private function swapChiselWithStub(): void
    {
        $this->acquireChiselLock();

        $chiselPath = base_path('chisel.php');

        if ($this->chiselBackupPath === null) {
            $this->chiselBackupPath = $chiselPath.'.test-backup';

            if (is_file($chiselPath)) {
                rename($chiselPath, $this->chiselBackupPath);
            }
        }

        copy(base_path('tests/fixtures/chisel-stub.php'), $chiselPath);
    }

    private function removeChiselFile(): void
    {
        $this->acquireChiselLock();

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

        if (is_file($this->chiselBackupPath)) {
            rename($this->chiselBackupPath, $chiselPath);
        }

        $this->chiselBackupPath = null;
    }

    private function acquireChiselLock(): void
    {
        if (is_resource(self::$chiselLockHandle)) {
            return;
        }

        $lockPath = base_path('chisel.php.test-lock');
        self::$chiselLockHandle = fopen($lockPath, 'c+');

        if (self::$chiselLockHandle === false) {
            $this->fail('Unable to create chisel.php lock file for parallel-safe tests.');
        }

        flock(self::$chiselLockHandle, LOCK_EX);
    }

    private function releaseChiselLock(): void
    {
        if (! is_resource(self::$chiselLockHandle)) {
            return;
        }

        flock(self::$chiselLockHandle, LOCK_UN);
        fclose(self::$chiselLockHandle);
        self::$chiselLockHandle = null;

        $lockPath = base_path('chisel.php.test-lock');

        if (is_file($lockPath)) {
            unlink($lockPath);
        }
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
