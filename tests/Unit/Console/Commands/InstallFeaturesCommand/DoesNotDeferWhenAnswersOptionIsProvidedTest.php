<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Concerns\ManagesChiselFileForTests;
use Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes\TestInstallFeaturesCommand;

uses(ManagesChiselFileForTests::class);

afterEach(function () {
    $this->restoreChiselFile();
    $this->releaseChiselLock();
    $this->clearDeferredInstallerHooks();
});

it('does not defer when answers option is provided', function () {
    $this->deferInstallerHooks();
    $this->swapChiselWithStub();
    $this->bindTestCommand();

    $this->artisan('install:features', [
        '--answers' => json_encode([]),
    ])->assertSuccessful();

    expect(TestInstallFeaturesCommand::$installNodeDependenciesCalls)->toBe(1);
    expect(TestInstallFeaturesCommand::$buildAssetsCalls)->toBe(1);
});
