<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

const benefitItems = [
    {
        title: 'Welcome people the right way',
        description: 'New customers feel looked after, not sold to, from day one.',
    },
    {
        title: 'Follow up without awkwardness',
        description: 'Gentle reminders that bring people back before they forget you.',
    },
    {
        title: 'Stay memorable between visits',
        description: 'Useful notes that keep your name familiar when they need you again.',
    },
    {
        title: 'Own the relationship',
        description: 'Your list is yours, not rented from an algorithm that can change overnight.',
    },
    {
        title: 'Simple enough to keep going',
        description: 'Systems you can stick with, not a campaign that dies after week two.',
    },
];

const processSteps = [
    {
        title: 'Understand your rhythm',
        description: 'When do customers usually hear from you? What should never feel salesy?',
    },
    {
        title: 'Map the key moments',
        description: 'Welcome, follow-up, re-engagement: only the messages that earn their place.',
    },
    {
        title: 'Write and set it up',
        description: 'Friendly copy and a simple system so sends actually happen.',
    },
    {
        title: 'Learn and refine',
        description: 'Watch what people open and respond to, then improve without reinventing everything.',
    },
];

const relatedServices = [
    { slug: 'lead-generation', label: 'Lead generation' },
    { slug: 'website-design-and-development', label: 'Website design & development' },
    { slug: 'business-automations', label: 'Business automations' },
    { slug: 'custom-software-development', label: 'Custom software development' },
];
</script>

<template>
    <Head title="Email Marketing for Small Businesses | Front Porch Creative">
        <meta
            name="description"
            content="Stay in touch with customers in Central Florida the friendly way: welcome series, follow-ups, and emails people actually want to open."
        />
        <meta property="og:title" content="Email marketing that feels personal" />
        <meta property="og:description" content="Keep interested customers warm, without sounding like a robot or blasting their inbox." />
        <meta property="og:image" content="/images/service-email-marketing/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Email marketing
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        Stay in touch in a way that feels human, so people remember you when they are ready.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We help small businesses use email to welcome new customers, follow up kindly, and stay top of mind, without spammy blasts or complicated tools you never open.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Plan friendlier follow-ups"
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
                        src="/images/service-email-marketing/hero.png"
                        alt="Warm illustration of personal emails connecting a business with its customers"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="Why email still matters"
        heading="A quiet channel that keeps working while you are busy"
        intro="Social posts disappear fast. Email lands where your customer already checks every day, when the tone is right."
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
        overline="The feeling we aim for"
        heading="Like a note from someone who knows your business, not a megaphone"
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:[&>*:first-child]:order-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Good email marketing sounds like you: clear, warm, and useful. We help you say the right thing at the right moment, a welcome after someone buys, a nudge when a quote is waiting, a seasonal note that feels timely instead of pushy.
                </p>
            </div>
            <VisualFrame
                src="/images/service-email-marketing/spotlight.png"
                alt="Illustration of a calm inbox with a welcome message that feels personal"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we work"
        heading="From first list to emails that feel like you"
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
        heading="Sitting on a list you barely use?"
        body="That is more common than you think. On a short call we can sketch which emails would actually help, and which ones to skip."
        button="Plan friendlier follow-ups"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="For owners who know their customers by name"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            Whether you are in Plant City, Tampa, Sarasota, or nearby, email is often the most personal way to stay close to people who already like what you do. We keep the tone local and human, the opposite of a national brand blasting templates.
        </p>
    </SectionShell>

    <SectionShell
        heading="No fake &quot;open rates&quot; theater"
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            We will not promise miracle metrics. Email works when the relationship is real and the message is useful. We focus on clarity, consistency, and respect for your customers' attention.
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
        heading="Want customers to hear from you, and be glad they did?"
        body="Let's map a few emails that sound like you and support real growth. No spam. No jargon. Just clearer follow-through."
        button="Plan friendlier follow-ups"
        test-id="service-closing-cta"
    />
</template>
