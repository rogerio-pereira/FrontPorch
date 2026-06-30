<?php

namespace Tests\Unit\Console\Fakes;

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
