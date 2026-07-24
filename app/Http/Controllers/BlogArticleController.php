<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class BlogArticleController extends Controller
{
    public function show(int $id): Response
    {
        /*
         * TODO: replace with Article::findOrFail($id) (or equivalent).
         *
         * Expected Inertia prop `article`:
         * {
         *   published: true,
         *   title: string,
         *   excerpt: string,
         *   category: string,
         *   publishedAt: string,
         *   author: string,
         *   coverImage: string,
         *   coverAlt: string,
         *   body: list<
         *     { type: 'paragraph'|'heading', text: string }
         *     | { type: 'image', src: string, alt: string }
         *   >,
         * }
         */
        if ($id !== 1) {
            abort(404);
        }

        return Inertia::render('blog-article/BlogArticle', [
            'article' => $this->demoArticle(),
        ]);
    }

    public function showBySlug(string $slug): Response
    {
        /*
         * TODO: look up Article by slug; if missing or unpublished, keep this placeholder shape.
         *
         * Expected Inertia prop `article` when not ready yet:
         * {
         *   published: false,
         *   title: string,
         *   coverImage: string,
         * }
         */
        $words = explode('-', $slug);
        $titleParts = [];

        foreach ($words as $word) {
            $titleParts[] = ucfirst($word);
        }

        $title = implode(' ', $titleParts);

        return Inertia::render('blog-article/BlogArticle', [
            'article' => [
                'published' => false,
                'title' => $title,
                'coverImage' => '/images/blog/listing.png',
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function demoArticle(): array
    {
        return [
            'published' => true,
            'title' => 'Why your website should feel like a front porch',
            'excerpt' => 'A calm, clear online presence helps small businesses earn trust before the first phone call.',
            'category' => 'Website strategy',
            'publishedAt' => 'June 18, 2026',
            'author' => 'Front Porch Creative',
            'coverImage' => '/images/blog-article/cover.png',
            'coverAlt' => 'Abstract geometric visual suggesting a calm digital front porch',
            'body' => [
                [
                    'type' => 'paragraph',
                    'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Curabitur pretium tincidunt lacus, at faucibus libero tincidunt eget.',
                ],
                [
                    'type' => 'heading',
                    'text' => 'Clarity beats cleverness',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa.',
                ],
                [
                    'type' => 'image',
                    'src' => '/images/blog-article/body-1.png',
                    'alt' => 'Abstract sage and navy geometric illustration supporting the article',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh.',
                ],
                [
                    'type' => 'heading',
                    'text' => 'Make the next step obvious',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet.',
                ],
                [
                    'type' => 'image',
                    'src' => '/images/blog-article/body-2.png',
                    'alt' => 'Second abstract illustration with soft glow accents on a dark background',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. Quisque volutpat condimentum velit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam nec ante.',
                ],
                [
                    'type' => 'paragraph',
                    'text' => 'Sed lacinia, urna non tincidunt mattis, tortor neque adipiscing diam, a cursus ipsum ante quis turpis. Nulla facilisi. Ut fringilla. Suspendisse potenti. Nunc feugiat mi a tellus consequat imperdiet. Vestibulum sapien. Proin quam.',
                ],
            ],
        ];
    }
}
