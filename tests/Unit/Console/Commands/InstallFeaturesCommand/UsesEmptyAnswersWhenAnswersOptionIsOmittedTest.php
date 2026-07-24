<?php

use Tests\Unit\Console\Commands\InstallFeaturesCommand\Concerns\ManagesChiselFileForTests;
use Tests\Unit\Console\Commands\InstallFeaturesCommand\Fakes\TestInstallFeaturesCommand;

uses(ManagesChiselFileForTests::class);

afterEach(function () {
    $this->restoreChiselFile();
    $this->releaseChiselLock();
    $this->clearDeferredInstallerHooks();
});

it('uses empty answers when answers option is omitted', function () {
    $this->swapChiselWithStub();
    $this->bindTestCommand();

    $this->artisan('install:features', [
        '--no-interaction' => true,
    ])->assertSuccessful();

    expect(TestInstallFeaturesCommand::$installNodeDependenciesCalls)->toBe(1);
    expect(TestInstallFeaturesCommand::$buildAssetsCalls)->toBe(1);
});
