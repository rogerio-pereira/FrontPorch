<?php

use App\Ai\Agents\BlogArticleWriterAgent;
use App\Ai\Tools\CreateBlogArticleTool;
use App\Ai\Tools\GenerateImageTool;
use App\Models\BlogArticle;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Ai;
use Laravel\Ai\Image;
use Laravel\Ai\Responses\Data\ToolCall;
use Laravel\Ai\Tools\Request;

it('schedules the weekly article command on monday at 08:00 America/New_York', function () {
    $event = collect(Schedule::events())->first(function ($event) {
        $command = (string) ($event->command ?? '');

        return str_contains($command, 'blog:generate-weekly-article')
            || str_contains($command, 'GenerateWeeklyBlogArticleCommand');
    });

    expect($event)->not->toBeNull()
        ->and($event->timezone)->toBe('America/New_York')
        ->and($event->expression)->toBe('0 8 * * 1');
});

it('creates a blog article via the create tool', function () {
    config(['app.name' => 'Front Porch Creative']);

    $message = (new CreateBlogArticleTool)->handle(new Request([
        'title' => 'A simple automation start',
        'description' => 'One reliable flow is enough.',
        'category' => 'Business automations',
        'content' => '<p>Hello.</p>',
        'image' => 'https://example.com/storage/blog/cover.png',
    ]));

    $article = BlogArticle::first();

    expect($message)->toContain('a-simple-automation-start')
        ->and($article)->not->toBeNull()
        ->and($article->published_by)->toBe('Front Porch Creative');
});

it('generates and stores an image via the image tool', function () {
    Storage::fake();
    Image::fake([base64_encode('png-bytes')]);

    $url = (new GenerateImageTool)->handle(new Request([
        'idea' => 'Abstract sage shapes',
        'directory' => 'blog',
    ]));

    expect($url)->toBeString()->not->toBeEmpty()
        ->and(Storage::allFiles('blog'))->toHaveCount(1);
});

it('runs the weekly command with a faked agent and creates one article', function () {
    Storage::fake();
    config([
        'app.name' => 'Front Porch Creative',
        'blog.weekly_article_enabled' => true,
    ]);
    Image::fake([base64_encode('cover')]);

    Ai::fakeAgent(BlogArticleWriterAgent::class, [
        new ToolCall('1', 'generate_image', [
            'idea' => 'Calm abstract shapes',
            'directory' => 'blog',
        ]),
        new ToolCall('2', 'create_blog_article', [
            'title' => 'Weekly porch tip',
            'description' => 'A short tip for Monday.',
            'category' => 'Business automations',
            'content' => '<p>Keep one follow-up from getting forgotten.</p>',
            'image' => 'https://example.com/storage/blog/cover.png',
        ]),
        'Done.',
    ]);

    expect(Artisan::call('blog:generate-weekly-article'))->toBe(0)
        ->and(BlogArticle::count())->toBe(1)
        ->and(BlogArticle::first()->title)->toBe('Weekly porch tip');
});

it('skips generation when the weekly article agent is disabled', function () {
    config(['blog.weekly_article_enabled' => false]);

    expect(Artisan::call('blog:generate-weekly-article'))->toBe(0)
        ->and(BlogArticle::count())->toBe(0);
});
