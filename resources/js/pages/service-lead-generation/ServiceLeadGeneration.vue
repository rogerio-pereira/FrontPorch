<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

const realityItems = [
    {
        title: 'Ads that get ignored',
        description: 'Spend goes out, but few people take the next step.',
    },
    {
        title: 'Visitors who leave unsure',
        description: 'Your site or landing page does not make it obvious why they should call or fill a form.',
    },
    {
        title: 'Leads that go cold',
        description: 'Someone reaches out, and then waits too long for a reply.',
    },
    {
        title: 'No clear picture',
        description: 'Hard to tell which channels actually bring paying customers.',
    },
];

const benefitItems = [
    {
        title: 'Reach people who already need you',
        description: 'Messages and offers aimed at the customers you actually want, not everyone with a pulse.',
    },
    {
        title: 'A clear reason to respond',
        description: 'Landing pages and offers that make the next step feel easy and worthwhile.',
    },
    {
        title: 'Follow-up that does not fall through',
        description: 'Simple paths so interested people hear back before they move on.',
    },
    {
        title: 'Numbers you can understand',
        description: 'Plain reporting on what is bringing inquiries, without a dashboard lecture.',
    },
    {
        title: 'Room to start small',
        description: 'Begin with a budget and scope that feel safe, then grow what works.',
    },
];

const processSteps = [
    {
        title: 'Listen first',
        description: 'We learn who you serve, what a good lead looks like, and what you can handle.',
    },
    {
        title: 'Shape the offer',
        description: 'Clarify the message and the path from "interested" to "in touch."',
    },
    {
        title: 'Launch with care',
        description: 'Put the pieces live (ads, pages, or both) and watch what happens together.',
    },
    {
        title: 'Adjust what matters',
        description: 'Keep what brings real conversations; change what does not.',
    },
];

const relatedServices = [
    { slug: 'email-marketing', label: 'Email marketing' },
    { slug: 'website-design-and-development', label: 'Website design & development' },
    { slug: 'business-automations', label: 'Business automations' },
    { slug: 'custom-software-development', label: 'Custom software development' },
];
</script>

<template>
    <Head title="Lead Generation for Small Businesses | Front Porch Creative">
        <meta
            name="description"
            content="Get more of the right inquiries in Central Florida: Plant City, Tampa, and Lakeland. Friendly lead generation that turns attention into real conversations."
        />
        <meta property="og:title" content="Lead generation that brings real inquiries" />
        <meta property="og:description" content="Reach people who need what you offer, and give them a clear reason to reach out." />
        <meta property="og:image" content="/images/service-lead-generation/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Lead generation
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        More of the right people reaching out, not just more noise online.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We help small businesses in Central Florida show up where customers are already looking, with a clear offer and a simple path to get in touch. The goal is real inquiries, not vanity clicks.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Talk about getting more leads"
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
                        src="/images/service-lead-generation/hero.png"
                        alt="Illustration of local customer inquiries flowing toward a small business"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="Sound familiar?"
        heading="Busy online, quiet inbox"
        intro="A lot of owners we meet are already posting, boosting, or hoping the website will &quot;just work.&quot; The missing piece is usually a clear path from attention to a real conversation."
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
        overline="What changes"
        heading="Lead generation that respects your time and your budget"
        intro="We focus on outcomes you can feel in the business: more qualified conversations, clearer next steps, and less guessing."
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
        overline="How it feels"
        heading="From &quot;hope it works&quot; to &quot;we know what is working&quot;"
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Lead generation should not feel like throwing money at the internet. We help you connect visibility, a clear offer, and a friendly follow-up, so when someone is ready, it is easy to choose you.
                </p>
            </div>
            <VisualFrame
                src="/images/service-lead-generation/spotlight.png"
                alt="Visual metaphor of a clear path from online attention to a booked conversation"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we work"
        heading="Simple steps, no mystery"
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
        heading="Wondering if paid ads (or organic) make sense for you?"
        body="That is exactly what a discovery call is for. We will talk through your goals and say so if lead generation is not the right first step."
        button="Talk about getting more leads"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="Built for businesses around Plant City, Tampa, and Lakeland"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            We are based in Plant City and work with small businesses across Central Florida, including Tampa, Brandon, Lakeland, and Wesley Chapel. Local context helps us speak your customers' language. If you are a little farther out and it is a good fit, we can still help.
        </p>
    </SectionShell>

    <SectionShell
        heading="Honest about where we are"
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            We are a newer agency. We will not invent case-study numbers to impress you. What we will do is listen carefully, explain options in plain English, and measure what actually brings inquiries, so you always know what you are paying for.
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
        heading="Ready for more of the right conversations?"
        body="Tell us who you want to reach. We will help you figure out a sensible way to get in front of them, and turn interest into real inquiries."
        button="Talk about getting more leads"
        test-id="service-closing-cta"
    />
</template>
