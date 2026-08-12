<?php

namespace App\Ai\Agents;

use App\Ai\Tools\CreateBlogArticleTool;
use App\Ai\Tools\GenerateImageTool;
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::OpenAI)]
#[MaxSteps(20)]
#[Timeout(300)]
class BlogArticleWriterAgent implements Agent, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        $path = base_path('docs/ai/ArticleWritter.md');

        if (! is_readable($path)) {
            return 'Write one English blog article and save it with create_blog_article. Use generate_image for images.';
        }

        return (string) file_get_contents($path);
    }

    /**
     * @return iterable<int, Tool>
     */
    public function tools(): iterable
    {
        return [
            // Using app() instead of new because GenerateImageTool has a dependency injection of ImageCompressor.
            app(GenerateImageTool::class),
            new CreateBlogArticleTool,
        ];
    }
}
