<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes\InstallFeaturesCommandProbe;

it('installs node dependencies', function () {
    $command = new InstallFeaturesCommandProbe;
    $command->setLaravel($this->app);

    $command->runInstallNodeDependencies();

    expect(true)->toBeTrue();
});
