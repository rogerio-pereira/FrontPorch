<?php

namespace Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes;

use App\Console\Commands\InstallFeaturesCommand;

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
