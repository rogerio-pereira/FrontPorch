<?php

namespace Database\Seeders;

use App\Models\BlogArticle;
use Illuminate\Database\Seeder;

class BlogArticlesSeeder extends Seeder
{
    /**
     * Seed the blog with the featured article plus the home page previews.
     *
     * Events are disabled so stable public slugs and the editorial author
     * credit can be set explicitly.
     */
    public function run(): void
    {
        BlogArticle::withoutEvents(function (): void {
            // Featured article
            BlogArticle::updateOrCreate(
                ['slug' => 'why-your-website-should-feel-like-a-front-porch'],
                [
                    'title' => 'Why your website should feel like a front porch',
                    'description' => 'A calm, clear online presence helps small businesses earn trust before the first phone call.',
                    'category' => 'Website strategy',
                    'image' => '/images/blog-article/cover.png',
                    'published_by' => 'Front Porch Creative',
                    'content' => implode('', [
                        '<p>Most people meet your business online long before they meet you. They check your site from a phone, in a parking lot, between two other errands. What they need in that moment is not a clever animation; it is the feeling that someone reasonable is on the other side.</p>',
                        '<p>A front porch works the same way. It is the part of the house that says come on up. It is not the whole story, just an honest invitation to hear the rest.</p>',
                        '<h2>Clarity beats cleverness</h2>',
                        '<p>Say what you do, who you do it for, and what happens next. When a visitor can answer those three questions in a few seconds, they relax, and relaxed people ask questions instead of closing the tab.</p>',
                        '<p>That usually means shorter headlines, plainer words, and one clear next step per page instead of five competing ones.</p>',
                        '<h2>Make the next step obvious</h2>',
                        '<p>Put the phone number, the form, or the booking link where a thumb can reach it. Repeat it at the end of every section that made someone nod along. Nobody should have to hunt for the way to reach you.</p>',
                        '<p>None of this requires a bigger budget. It requires deciding what matters most on each page and letting the rest go quiet.</p>',
                    ]),
                ]
            );

            // Home preview — website
            BlogArticle::updateOrCreate(
                ['slug' => 'your-website-works-when-you-are-not'],
                [
                    'title' => 'Your website works when you are not',
                    'description' => 'Most customers look you up before they call. Here is how to make that first impression count.',
                    'category' => 'Website strategy',
                    'image' => '/images/home/blog-website.png',
                    'published_by' => 'Front Porch Creative',
                    'content' => implode('', [
                        '<p>Your site is open at 10pm on a Sunday, while you are asleep and your competitor is not answering the phone either. That is when a lot of small business decisions get made.</p>',
                        '<h2>Answer the quiet questions</h2>',
                        '<p>Do you serve my town? How much does this usually cost? Will someone actually call me back? Answering those in plain language does more for trust than any badge or slogan.</p>',
                        '<p>Write the page you would want to read if you were the one looking for help.</p>',
                    ]),
                ]
            );

            // Home preview — automations
            BlogArticle::updateOrCreate(
                ['slug' => 'small-automations-that-save-big-chunks-of-time'],
                [
                    'title' => 'Small automations that save big chunks of time',
                    'description' => 'Start with the tasks you do every week, the relief is often immediate.',
                    'category' => 'Automation',
                    'image' => '/images/home/blog-automations.png',
                    'published_by' => 'Front Porch Creative',
                    'content' => implode('', [
                        '<p>Automation sounds like a big project. In practice, the wins that matter are small: an email that sends itself, a form that fills in the calendar, a reminder nobody has to remember.</p>',
                        '<h2>Start with the weekly annoyance</h2>',
                        '<p>Pick the task you repeat every week and dislike every time. Automate that one first, then live with it for a couple of weeks before adding anything else.</p>',
                        '<p>Momentum beats ambition here. Two small automations that stick are worth more than a grand plan nobody maintains.</p>',
                    ]),
                ]
            );
        });
    }
}
