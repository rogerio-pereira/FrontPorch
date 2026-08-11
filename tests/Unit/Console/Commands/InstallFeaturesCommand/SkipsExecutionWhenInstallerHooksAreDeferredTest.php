<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Concerns\ManagesChiselFileForTests;

uses(ManagesChiselFileForTests::class);

afterEach(function () {
    $this->restoreChiselFile();
    $this->releaseChiselLock();
    $this->clearDeferredInstallerHooks();
});

it('skips execution when installer hooks are deferred', function () {
    $this->deferInstallerHooks();

    $this->artisan('install:features')->assertSuccessful();
});
