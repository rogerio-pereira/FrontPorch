<?php

namespace Tests\Unit\Console\Concerns;

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
            rename($chiselPath, $this->chiselBackupPath);
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

        rename($this->chiselBackupPath, $chiselPath);
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
}
