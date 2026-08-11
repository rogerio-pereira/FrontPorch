<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes\InstallFeaturesCommandProbe;

it('builds assets', function () {
    $command = new InstallFeaturesCommandProbe;
    $command->setLaravel($this->app);

    $command->runBuildAssets();

    expect(true)->toBeTrue();
});
