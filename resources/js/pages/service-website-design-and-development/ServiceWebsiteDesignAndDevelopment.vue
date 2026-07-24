<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

const realityItems = [
    {
        title: 'Hard to use on a phone',
        description: 'Most people find you on mobile first. If the site fights them, they leave.',
    },
    {
        title: 'Unclear next step',
        description: 'Visitors like what they see, then are not sure whether to call, book, or fill a form.',
    },
    {
        title: 'Outdated or slow',
        description: 'It feels tired, loads slowly, or no longer matches the quality of your work.',
    },
    {
        title: 'Disconnected from the rest',
        description: 'The site sits alone, while email, ads, and follow-up live somewhere else.',
    },
];

const benefitItems = [
    {
        title: 'Trust in the first few seconds',
        description: 'Clean design and clear words that match the care you put into your work.',
    },
    {
        title: 'Easy on every phone',
        description: 'Readable, tappable, and quick, because that is how most people will meet you.',
    },
    {
        title: 'An obvious next step',
        description: 'Call, book, or message without hunting for a tiny link.',
    },
    {
        title: 'Room to grow',
        description: 'Built so you can add pages, offers, or tools later without starting from zero.',
    },
    {
        title: 'Connected to your growth plan',
        description: 'Designed to work with lead gen, email, and the processes behind the scenes.',
    },
];

const processSteps = [
    {
        title: 'Discovery',
        description: 'Goals, audience, and what "success" looks like for your site.',
    },
    {
        title: 'Structure and design',
        description: 'A layout visitors can scan, with your brand front and center.',
    },
    {
        title: 'Build and refine',
        description: 'We assemble, polish, and check everything on real devices.',
    },
    {
        title: 'Launch and handoff',
        description: 'Go live with a clear walkthrough so you know how to update the basics.',
    },
];

const relatedServices = [
    { slug: 'lead-generation', label: 'Lead generation' },
    { slug: 'email-marketing', label: 'Email marketing' },
    { slug: 'business-automations', label: 'Business automations' },
    { slug: 'custom-software-development', label: 'Custom software development' },
];
</script>

<template>
    <Head title="Website Design & Development | Front Porch Creative">
        <meta
            name="description"
            content="Mobile-friendly websites for small businesses in Plant City, Tampa, and Central Florida: clear, fast, and built to turn visitors into inquiries."
        />
        <meta property="og:title" content="A website that works as hard as you do" />
        <meta property="og:description" content="Look trustworthy, load fast on phones, and make the next step obvious." />
        <meta property="og:image" content="/images/service-website-design-and-development/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Website design & development
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        A site that looks like you, works on phones, and makes it easy to take the next step.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We design and build websites for small businesses who need more than a pretty brochure, pages that explain what you offer, earn trust quickly, and invite real inquiries.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Talk about a better website"
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
                        src="/images/service-website-design-and-development/hero.png"
                        alt="Modern small business website displayed on phone and desktop"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="If this feels familiar"
        heading="&quot;We have a website&quot; is not the same as &quot;it helps us grow&quot;"
        intro="Plenty of sites look fine in a screenshot and still quietly lose customers every week."
        light
        wide
    >
        <div class="grid gap-4 sm:grid-cols-2">
            <article
                v-for="(item, index) in realityItems"
                :key="item.title"
                class="rounded-xl border border-border-default bg-white p-5"
            >
                <p class="text-overline text-brand-accent">
                    {{ String(index + 1).padStart(2, '0') }}
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    {{ item.title }}
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    {{ item.description }}
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="What a strong site does for you"
        heading="Clarity, speed, and confidence for you and your visitors"
        intro="We care about how the site feels to a busy local customer who has never heard of you before."
        wide
    >
        <div class="mx-auto max-w-3xl space-y-5">
            <article
                v-for="item in benefitItems"
                :key="item.title"
                class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6"
            >
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    {{ item.title }}
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    {{ item.description }}
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="Design with a job to do"
        heading="Beautiful is nice. Useful is better. We aim for both."
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Your website is often the first conversation someone has with your business. We treat that moment with care, calm layouts, plain language, and CTAs that feel inviting instead of pushy. Think front-porch hospitality, not a hard sell.
                </p>
            </div>
            <VisualFrame
                src="/images/service-website-design-and-development/spotlight.png"
                alt="Calm website layout emphasizing clarity and a clear call to action"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we build"
        heading="Collaborative, clear, and never a black box"
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article
                v-for="(step, index) in processSteps"
                :key="step.title"
                class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left"
            >
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    {{ index + 1 }}
                </div>
                <h3 class="font-semibold">
                    {{ step.title }}
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    {{ step.description }}
                </p>
            </article>
        </div>
    </SectionShell>

    <CtaBand
        heading="Not sure if you need a refresh or a full rebuild?"
        body="Bring what you have. We will look together and suggest the smallest change that actually helps, with no pressure to buy the biggest package."
        button="Talk about a better website"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="Websites for businesses people search for nearby"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            From Plant City to Tampa, Brandon, Lakeland, and Wesley Chapel, local customers compare options online before they call. A clear, mobile-friendly site helps you show up as the obvious choice, not the one they skip because the page felt confusing.
        </p>
    </SectionShell>

    <SectionShell
        heading="No mystery rebuilds"
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            We explain what we recommend and why, including when a full redesign is overkill. Sometimes a focused refresh beats starting over. You will always get a written proposal before we build.
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
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <Link
                v-for="service in relatedServices"
                :key="service.slug"
                :href="`/services/${service.slug}`"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                :data-test="`service-related-${service.slug}`"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    {{ service.label }}
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
        </div>
    </SectionShell>

    <CtaBand
        heading="Ready for a site that works while you are working?"
        body="Let's talk about what your visitors need to see, and how to make the next step feel easy."
        button="Talk about a better website"
        test-id="service-closing-cta"
    />
</template>
