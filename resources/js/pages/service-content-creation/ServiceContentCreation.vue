<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import ServiceFaqSection from '@/layouts/app/ServiceFaqSection.vue';
import ServiceTestimonialsSection from '@/layouts/app/ServiceTestimonialsSection.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

defineProps<{
    faqs: Array<{ question: string; answer: string }>;
    testimonials: Array<{ testimonial: string; person: string }>;
}>();
</script>

<template>
    <Head title="Content Creation | Front Porch Creative">
        <meta
            name="description"
            content="Blog posts and social media writing for small businesses in Plant City, Tampa, and Central Florida: clear, friendly copy that keeps you visible without the scramble."
        />
        <meta property="og:title" content="Words that keep your business visible" />
        <meta property="og:description" content="Blog posts and social captions that sound like you, on a schedule you can keep." />
        <meta property="og:image" content="/images/service-content-creation/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Content creation
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        Blog posts and social writing that keep you visible between busy weeks.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We write the words: articles for your site and posts for the platforms you already use. Clear, friendly, and consistent, so customers keep hearing from you without you staring at a blank screen.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Talk about content help"
                            size="lg"
                            test-id="service-schedule"
                        />
                        <Link
                            href="/#contact"
                            class="inline-flex h-11 items-center justify-center rounded-md border border-brand-accent/50 px-6 text-sm font-semibold text-brand-accent transition hover:bg-brand-accent/10"
                            data-test="service-contact"
                        >
                            Send a message
                        </Link>
                    </div>
                </div>

                <div
                    class="relative motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-right-4 motion-safe:duration-700 motion-safe:delay-150"
                    data-test="service-hero-visual"
                >
                    <div class="absolute -inset-4 rounded-2xl bg-brand-accent/10 blur-2xl" />
                    <VisualFrame
                        src="/images/service-content-creation/hero.png"
                        alt="Blog and social writing flowing toward a small business storefront"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="If this feels familiar"
        heading="You know you should post. The blank page keeps winning."
        intro="Most small businesses do not need more platforms. They need words that show up reliably."
        light
        wide
    >
        <div class="grid gap-4 sm:grid-cols-2">
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    01
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Silence between jobs
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Weeks go by with nothing new on the site or social, so people forget you exist.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    02
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Generic or stiff copy
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    What you do publish sounds like every other business, or nothing like how you talk in person.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    03
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    No time to write
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Serving customers comes first. Drafting posts keeps sliding to the bottom of the list.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    04
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Unsure what to say
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    You know your craft. Turning that into helpful posts and captions still feels awkward.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="What steady writing does for you"
        heading="Show up with clarity, not content for content's sake"
        intro="We focus on useful words that support trust, search, and staying top of mind."
        wide
    >
        <div class="mx-auto max-w-3xl space-y-5">
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Blog posts that answer real questions
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Articles that help locals understand what you offer, how you work, and why you are a good fit.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Social captions that sound human
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Short posts and updates for the platforms you already use, written in your voice.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    A pace you can keep
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    A written schedule that fits your capacity, not a firehose of daily posts you will abandon.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Support for search over time
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Useful site content that pairs with a solid website and helps people find you when they search.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    You approve before it goes live
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Drafts for review, plain feedback, and edits until it feels like you.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="Words with a job to do"
        heading="We write. You stay the face of the business."
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Content creation here means written blog posts and social media presence: captions, updates, and articles. We do not take photos or record videos. You bring images from your work when a post needs them, and we focus on the words that make the post worth reading.
                </p>
            </div>
            <VisualFrame
                src="/images/service-content-creation/spotlight.png"
                alt="Editorial draft and content schedule for blog and social writing"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we work"
        heading="Simple rhythm, clear ownership"
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold">
                    Discovery
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Your voice, audience, platforms, and what "showing up" should achieve.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold">
                    Topics and calendar
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    A practical mix of blog and social ideas at a sustainable pace.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold">
                    Draft and revise
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    We write; you review. We polish until it sounds right.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold">
                    Publish and keep going
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Content goes out on schedule, then we plan the next batch together.
                </p>
            </article>
        </div>
    </SectionShell>

    <CtaBand
        heading="Tired of promising yourself you will post next week?"
        body="Bring the platforms you already use. We will suggest a writing plan that fits your week, with no pressure to be everywhere at once."
        button="Talk about content help"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="Local stories for businesses neighbors actually search for"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            From Plant City to Tampa, Brandon, Lakeland, Wesley Chapel, Orlando, and Sarasota, people look online before they call. Steady, useful writing helps you show up as the familiar choice, not the blank profile they skip.
        </p>
    </SectionShell>

    <SectionShell
        heading="No content mills. No fake expertise."
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            We write from what you tell us about the business, not keyword soup. If a blog post or social cadence will not help right now, we will say so and point you toward a better first step.
        </p>
    </SectionShell>

    <SectionShell
        overline="Also explore"
        heading="Other ways we can help"
        intro="Each service stands alone, and they work even better together."
        light
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <Link
                href="/services/lead-generation"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-lead-generation"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Lead generation
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
            <Link
                href="/services/email-marketing"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-email-marketing"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Email marketing
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
            <Link
                href="/services/website-design-and-development"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-website-design-and-development"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Website design &amp; development
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
            <Link
                href="/services/business-automations"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-business-automations"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Business automations
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
            <Link
                href="/services/custom-software-development"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-custom-software-development"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Custom software development
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
        </div>
    </SectionShell>

    <ServiceTestimonialsSection :testimonials="testimonials" />
    <ServiceFaqSection :faqs="faqs" />

    <CtaBand
        heading="Ready for writing that shows up when you cannot?"
        body="Let's sketch a simple content plan for your blog and social presence, focused on words that sound like you."
        button="Talk about content help"
        test-id="service-closing-cta"
    />
</template>
