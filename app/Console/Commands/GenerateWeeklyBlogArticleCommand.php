<?php

namespace App\Console\Commands;

use App\Ai\Agents\BlogArticleWriterAgent;
use App\Models\BlogArticle;
use App\Models\Service;
use Illuminate\Console\Command;

class GenerateWeeklyBlogArticleCommand extends Command
{
    protected $signature = 'blog:generate-weekly-article';

    protected $description = 'Generate and publish one weekly English blog article';

    public function handle(): int
    {
        if (config('blog.weekly_article_enabled') == false) {
            $this->info('Weekly blog article generation is disabled (BLOG_WEEKLY_ARTICLE_ENABLED).');

            return self::SUCCESS;
        }

        $services = Service::orderBy('sort_order')
                        ->get(['title', 'description'])
                        ->toJson(JSON_PRETTY_PRINT);

        $recentTitles = BlogArticle::where('created_at', '>=', now()->subYear())
                            ->orderByDesc('created_at')
                            ->pluck('title')
                            ->toJson(JSON_PRETTY_PRINT);

        $prompt = "Create exactly one new English blog article.\n\n".
                    "Services:\n".
                    "{$services}\n\n".
                    "Recent article titles (do not duplicate):\n".
                    "{$recentTitles}\n".
                    "Use generate_image for the cover (directory blog) and optional inline images.\n".
                    'Then call create_blog_article once. Do nothing else.';

        $agent = new BlogArticleWriterAgent;

        $response = $agent->prompt(
            $prompt,
            timeout: 300,
        );

        $message = (string) $response;

        $this->info($message);

        return self::SUCCESS;
    }
}
