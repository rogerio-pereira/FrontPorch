<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Concerns\ManagesChiselFileForTests;

uses(ManagesChiselFileForTests::class);

afterEach(function () {
    $this->restoreChiselFile();
    $this->releaseChiselLock();
    $this->clearDeferredInstallerHooks();
});

it('returns success when chisel file is missing', function () {
    $this->removeChiselFile();

    $this->artisan('install:features', [
        '--answers' => json_encode([]),
    ])->assertSuccessful();
});
