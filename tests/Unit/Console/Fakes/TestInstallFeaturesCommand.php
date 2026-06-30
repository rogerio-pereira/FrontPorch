<?php

namespace Tests\Unit\Console\Fakes;

use App\Console\Commands\InstallFeaturesCommand;

class TestInstallFeaturesCommand extends InstallFeaturesCommand
{
    public static int $installNodeDependenciesCalls = 0;

    public static int $buildAssetsCalls = 0;

    public static function resetCallCounts(): void
    {
        self::$installNodeDependenciesCalls = 0;
        self::$buildAssetsCalls = 0;
    }

    protected function installNodeDependencies(): void
    {
        self::$installNodeDependenciesCalls++;
    }

    protected function buildAssets(): void
    {
        self::$buildAssetsCalls++;
    }
}
