<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import ServiceFaqSection from '@/layouts/app/ServiceFaqSection.vue';
import ServiceRelatedSection from '@/layouts/app/ServiceRelatedSection.vue';
import ServiceTestimonialsSection from '@/layouts/app/ServiceTestimonialsSection.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

defineProps<{
    faqs: Array<{ question: string; answer: string }>;
    testimonials: Array<{ testimonial: string; person: string }>;
    relatedServices: Record<string, string>;
}>();
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
        light
        wide
    >
        <div class="mx-auto max-w-3xl space-y-5">
            <article class="rounded-xl border border-border-default bg-white p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Welcome people the right way
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-light)]">
                    New customers feel looked after, not sold to, from day one.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Follow up without awkwardness
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-light)]">
                    Gentle reminders that bring people back before they forget you.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Stay memorable between visits
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-light)]">
                    Useful notes that keep your name familiar when they need you again.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Own the relationship
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-light)]">
                    Your list is yours, not rented from an algorithm that can change overnight.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Simple enough to keep going
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-light)]">
                    Systems you can stick with, not a campaign that dies after week two.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="The feeling we aim for"
        heading="Like a note from someone who knows your business, not a megaphone"
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:[&>*:first-child]:order-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
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
        light
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-white p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Understand your rhythm
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    When do customers usually hear from you? What should never feel salesy?
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-white p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Map the key moments
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Welcome, follow-up, re-engagement: only the messages that earn their place.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-white p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Write and set it up
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Friendly copy and a simple system so sends actually happen.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-white p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Learn and refine
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Watch what people open and respond to, then improve without reinventing everything.
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
            Whether you are in Plant City, Tampa, Orlando, Sarasota, or nearby, email is often the most personal way to stay close to people who already like what you do. We keep the tone local and human, the opposite of a national brand blasting templates.
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

    <ServiceTestimonialsSection
        :testimonials="testimonials"
        light
    />
    <ServiceFaqSection :faqs="faqs" />
    <ServiceRelatedSection
        :services="relatedServices"
        light
    />

    <CtaBand
        heading="Want customers to hear from you, and be glad they did?"
        body="Let's map a few emails that sound like you and support real growth. No spam. No jargon. Just clearer follow-through."
        button="Plan friendlier follow-ups"
        test-id="service-closing-cta"
    />
</template>
