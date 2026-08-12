<?php

use App\Ai\Agents\BlogArticleWriterAgent;
use App\Ai\Tools\CreateBlogArticleTool;
use App\Ai\Tools\GenerateImageTool;
use App\Models\BlogArticle;
use Illuminate\JsonSchema\JsonSchemaTypeFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
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

it('loads article writer instructions from the prompt file', function () {
    $agent = new BlogArticleWriterAgent;

    $instructions = (string) $agent->instructions();

    expect($instructions)->toContain('Front Porch Creative')
        ->and($agent->tools())->toHaveCount(2);
});

it('falls back to short instructions when the prompt file is missing', function () {
    $path = base_path('docs/ai/ArticleWritter.md');
    $backup = $path.'.bak-test';

    File::move($path, $backup);

    try {
        $instructions = (string) (new BlogArticleWriterAgent)->instructions();

        expect($instructions)->toContain('create_blog_article')
            ->and($instructions)->toContain('generate_image');
    } finally {
        File::move($backup, $path);
    }
});

it('creates a blog article via the create tool', function () {
    config(['app.name' => 'Front Porch Creative']);

    $tool = new CreateBlogArticleTool;

    expect($tool->name())->toBe('create_blog_article')
        ->and((string) $tool->description())->toContain('Create and publish one blog article');

    $schema = $tool->schema(new JsonSchemaTypeFactory);

    expect($schema)->toHaveKeys(['title', 'description', 'category', 'content', 'image']);

    $message = $tool->handle(new Request([
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

it('generates and stores a web-optimized jpeg via the image tool', function () {
    Storage::fake();
    $png = createAiTestPngBinary(320, 240);
    Image::fake([base64_encode($png)]);

    $tool = app(GenerateImageTool::class);

    expect($tool->name())->toBe('generate_image')
        ->and((string) $tool->description())->toContain('Generate an image')
        ->and($tool->schema(new JsonSchemaTypeFactory))->toHaveKeys(['idea', 'directory']);

    $url = $tool->handle(new Request([
        'idea' => 'Abstract sage shapes',
        'directory' => 'blog',
    ]));

    $storedFiles = Storage::allFiles('blog');
    $storedPath = $storedFiles[0];
    $storedBinary = Storage::get($storedPath);

    expect($url)->toBeString()->not->toBeEmpty()
        ->and($storedFiles)->toHaveCount(1)
        ->and($storedPath)->toEndWith('.jpg')
        ->and(strlen($storedBinary))->toBeLessThan(strlen($png))
        ->and(substr($storedBinary, 0, 2))->toBe("\xFF\xD8");
});

it('defaults the image directory to blog when the argument is empty', function () {
    Storage::fake();
    Image::fake([base64_encode(createAiTestPngBinary(16, 16))]);

    $url = app(GenerateImageTool::class)->handle(new Request([
        'idea' => 'Calm shapes',
        'directory' => '',
    ]));

    expect($url)->toBeString()->not->toBeEmpty()
        ->and(Storage::allFiles('blog'))->toHaveCount(1)
        ->and(Storage::allFiles('blog')[0])->toEndWith('.jpg');
});

it('runs the weekly command with a faked agent and creates one article', function () {
    Storage::fake();
    config([
        'app.name' => 'Front Porch Creative',
        'blog.weekly_article_enabled' => true,
    ]);
    Image::fake([base64_encode(createAiTestPngBinary(16, 16))]);

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
            'image' => 'https://example.com/storage/blog/cover.jpg',
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

function createAiTestPngBinary(int $width, int $height): string
{
    $image = imagecreatetruecolor($width, $height);

    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $red = (int) (120 + 80 * sin($x / 40) + 20 * sin($y / 30));
            $green = (int) (100 + 70 * cos($x / 50) + 15 * cos($y / 25));
            $blue = (int) (90 + 60 * sin(($x + $y) / 60));
            $color = imagecolorallocate(
                $image,
                max(0, min(255, $red)),
                max(0, min(255, $green)),
                max(0, min(255, $blue)),
            );
            imagesetpixel($image, $x, $y, $color);
        }
    }

    ob_start();
    imagepng($image, null, 0);
    $binary = (string) ob_get_clean();
    imagedestroy($image);

    return $binary;
}
