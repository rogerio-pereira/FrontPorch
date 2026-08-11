<?php

use App\Models\CaseStudy;

it('derives the slug from the title on create', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'Porch Light Rebrand',
                    ]);

    $slug = $caseStudy->slug;

    expect($slug)->toBe('porch-light-rebrand');
});

it('keeps the slug when the title is unchanged', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'Porch Light Rebrand',
                    ]);

    $caseStudy->update([
        'client' => 'Porch Light Co.',
    ]);

    $slug = $caseStudy->slug;

    expect($slug)->toBe('porch-light-rebrand');
});

it('regenerates the slug when the title changes', function () {
    $caseStudy = CaseStudy::factory()
                    ->create([
                        'title' => 'Porch Light Rebrand',
                    ]);

    $caseStudy->update([
        'title' => 'Front Door Refresh',
    ]);

    $slug = $caseStudy->slug;

    expect($slug)->toBe('front-door-refresh');
});

it('rejects a title that cannot produce a slug', function () {
    CaseStudy::factory()
        ->create([
            'title' => '###',
        ]);
})->throws(InvalidArgumentException::class);
