<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\CaseStudyImage;
use App\Models\Service;
use Illuminate\Database\Seeder;

class CaseStudiesSeeder extends Seeder
{
    /**
     * Seed the portfolio with the flagship case study plus preview entries.
     */
    public function run(): void
    {
        foreach ($this->caseStudies() as $caseStudy) {
            $this->persist($caseStudy);
        }
    }

    /**
     * Create or refresh a case study with its services and gallery images.
     *
     * @param  array{slug: string, title: string, description: string, client: string, industry: string, challenge: string, content: string, services: list<string>, images: list<array{url: string, alt: string}>}  $attributes
     */
    protected function persist(array $attributes): void
    {
        $caseStudy = CaseStudy::where('slug', $attributes['slug'])->first();

        $values = [
            'title' => $attributes['title'],
            'description' => $attributes['description'],
            'client' => $attributes['client'],
            'industry' => $attributes['industry'],
            'challenge' => $attributes['challenge'],
            'content' => $attributes['content'],
        ];

        if ($caseStudy === null) {
            $caseStudy = CaseStudy::create($values);
        } else {
            $caseStudy->update($values);
        }

        // The CaseStudyObserver derives the slug from the title; the public
        // portfolio URLs rely on the slug below staying stable.
        if ($caseStudy->slug !== $attributes['slug']) {
            $caseStudy->forceFill(['slug' => $attributes['slug']])->saveQuietly();
        }

        $caseStudy->services()->sync($this->serviceIds($attributes['services']));

        $sortOrder = 0;

        foreach ($attributes['images'] as $image) {
            CaseStudyImage::updateOrCreate(
                [
                    'case_study_id' => $caseStudy->id,
                    'sort_order' => $sortOrder,
                ],
                [
                    'url' => $image['url'],
                    'alt' => $image['alt'],
                ],
            );

            $sortOrder++;
        }
    }

    /**
     * Resolve the service ids for the given slugs.
     *
     * @param  list<string>  $slugs
     * @return list<string>
     */
    protected function serviceIds(array $slugs): array
    {
        $ids = [];

        foreach ($slugs as $slug) {
            $service = Service::where('slug', $slug)->first();

            if ($service === null) {
                continue;
            }

            $ids[] = $service->id;
        }

        return $ids;
    }

    /**
     * @return list<array{slug: string, title: string, description: string, client: string, industry: string, challenge: string, content: string, services: list<string>, images: list<array{url: string, alt: string}>}>
     */
    protected function caseStudies(): array
    {
        return [
            [
                'slug' => 'from-missed-calls-to-booked-jobs',
                'title' => 'From missed calls to booked jobs',
                'description' => 'Cypress & Oak did excellent work in the field, but online, interested homeowners often left without booking. Together we rebuilt their digital front porch so the next step felt obvious.',
                'client' => 'Cypress & Oak Home Services',
                'industry' => 'Home services',
                'challenge' => 'The team was busy on jobsites, yet evenings still meant digging through voicemails, Facebook messages, and half-filled contact forms. Their website looked dated on phones, buried the phone number, and offered no clear path to request service. Good leads cooled off before anyone could reply.',
                'content' => implode('', [
                    '<p>We started with a discovery conversation about how they actually win work, not a wishlist of features. Then we designed a mobile-first site that explains services in plain English, surfaces trust signals, and makes booking the easiest action on every page.</p>',
                    '<p>The homepage answers "Can you help me?" within a few seconds. Service pages match how homeowners search. A simple request form connects to email alerts and a shared calendar hold, with a short follow-up sequence so no inquiry sits unanswered overnight.</p>',
                    '<blockquote><p>We finally feel like our website works while we are out on jobs. People find us, ask for help, and we know exactly what to do next.</p><footer>Owner, Cypress &amp; Oak Home Services</footer></blockquote>',
                    '<p>This project was never about a flashy redesign. It was about giving a local team a front porch online, welcoming, clear, and ready when a neighbor needs help.</p>',
                ]),
                'services' => ['website-design-and-development', 'lead-generation'],
                'images' => [
                    [
                        'url' => '/images/portfolio-study-case/cover.png',
                        'alt' => 'Homepage overview for Cypress & Oak Home Services',
                    ],
                    [
                        'url' => '/images/portfolio-study-case/process.png',
                        'alt' => 'Service request flow connecting inquiries to booked appointments',
                    ],
                    [
                        'url' => '/images/portfolio-study-case/gallery-a.png',
                        'alt' => 'Services page layout for homeowners searching on mobile',
                    ],
                    [
                        'url' => '/images/portfolio-study-case/gallery-b.png',
                        'alt' => 'Contact and booking page with a clear next step',
                    ],
                ],
            ],
            [
                'slug' => 'website-for-a-local-service-business',
                'title' => 'Website for a local service business',
                'description' => 'A clean, mobile-friendly site that explains services and makes contact easy.',
                'client' => 'Magnolia Field Services',
                'industry' => 'Home services',
                'challenge' => 'Their old site was three pages of stock photos and no clear way to ask for a quote, so most visitors left without reaching out.',
                'content' => '<p>We rewrote each service page around the questions homeowners actually ask, then put a short quote form and a phone number within reach on every screen.</p>',
                'services' => ['website-design-and-development'],
                'images' => [
                    [
                        'url' => '/images/home/portfolio-a.png',
                        'alt' => 'Homepage layout for a local service business',
                    ],
                    [
                        'url' => '/images/home/portfolio-b.png',
                        'alt' => 'Quote request form on a mobile screen',
                    ],
                ],
            ],
            [
                'slug' => 'lead-follow-up-for-home-services',
                'title' => 'Lead follow-up for home services',
                'description' => 'A simple path from first click to booked appointment, without lost leads.',
                'client' => 'Ridgeline Comfort Co.',
                'industry' => 'Heating and cooling',
                'challenge' => 'Inquiries arrived through four different channels and nobody owned the follow-up, so warm leads went cold overnight.',
                'content' => '<p>Every inquiry now lands in one inbox with an automatic reply, a reminder for the office, and a short follow-up sequence that stops as soon as someone books.</p>',
                'services' => ['lead-generation'],
                'images' => [
                    [
                        'url' => '/images/home/portfolio-b.png',
                        'alt' => 'Lead follow-up flow from inquiry to booked appointment',
                    ],
                    [
                        'url' => '/images/home/portfolio-c.png',
                        'alt' => 'Shared inbox view of incoming service requests',
                    ],
                ],
            ],
            [
                'slug' => 'email-welcome-series-for-retail',
                'title' => 'Email welcome series for retail',
                'description' => 'Warm emails that introduce new customers and keep them coming back.',
                'client' => 'Bramble & Bee Mercantile',
                'industry' => 'Retail',
                'challenge' => 'A growing mailing list sat unused because writing a newsletter from scratch every month never made it to the top of the list.',
                'content' => '<p>We wrote a three-email welcome series in the shop owner\'s own voice and set it to run automatically for every new subscriber.</p>',
                'services' => ['email-marketing'],
                'images' => [
                    [
                        'url' => '/images/home/portfolio-c.png',
                        'alt' => 'Welcome email sequence for a retail shop',
                    ],
                    [
                        'url' => '/images/home/portfolio-a.png',
                        'alt' => 'Signup form placement on a retail website',
                    ],
                ],
            ],
            [
                'slug' => 'easier-appointment-booking',
                'title' => 'Easier appointment booking',
                'description' => 'Forms and calendars connected so nobody re-types the same information.',
                'client' => 'Hillside Family Wellness',
                'industry' => 'Health and wellness',
                'challenge' => 'Front desk staff copied every request from a web form into the calendar by hand, which cost hours each week and caused double bookings.',
                'content' => '<p>The booking form now writes straight to the shared calendar, confirms by email, and blocks slots that are already taken.</p>',
                'services' => ['business-automations'],
                'images' => [
                    [
                        'url' => '/images/home/portfolio-a.png',
                        'alt' => 'Appointment booking form connected to a shared calendar',
                    ],
                    [
                        'url' => '/images/home/portfolio-b.png',
                        'alt' => 'Calendar view with automatically blocked time slots',
                    ],
                ],
            ],
            [
                'slug' => 'client-portal-for-a-firm',
                'title' => 'Client portal for a firm',
                'description' => 'One place to share files and updates, with less email back-and-forth.',
                'client' => 'Oakwood Advisory Group',
                'industry' => 'Professional services',
                'challenge' => 'Documents lived in long email threads, so clients asked for the same file twice and nobody was sure which version was current.',
                'content' => '<p>We built a small portal where each client signs in to see their documents, current status, and next steps, with notifications when something new arrives.</p>',
                'services' => ['custom-software-development'],
                'images' => [
                    [
                        'url' => '/images/home/portfolio-c.png',
                        'alt' => 'Client portal dashboard listing shared documents',
                    ],
                    [
                        'url' => '/images/home/portfolio-b.png',
                        'alt' => 'Document upload screen inside the client portal',
                    ],
                ],
            ],
        ];
    }
}
