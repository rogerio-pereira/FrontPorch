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
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    01
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Ads that get ignored
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Spend goes out, but few people take the next step.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    02
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Visitors who leave unsure
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Your site or landing page does not make it obvious why they should call or fill a form.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    03
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Leads that go cold
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Someone reaches out, and then waits too long for a reply.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    04
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    No clear picture
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Hard to tell which channels actually bring paying customers.
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
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Reach people who already need you
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Messages and offers aimed at the customers you actually want, not everyone with a pulse.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    A clear reason to respond
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Landing pages and offers that make the next step feel easy and worthwhile.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Follow-up that does not fall through
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Simple paths so interested people hear back before they move on.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Numbers you can understand
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Plain reporting on what is bringing inquiries, without a dashboard lecture.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Room to start small
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Begin with a budget and scope that feel safe, then grow what works.
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
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold">
                    Listen first
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    We learn who you serve, what a good lead looks like, and what you can handle.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold">
                    Shape the offer
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Clarify the message and the path from "interested" to "in touch."
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold">
                    Launch with care
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Put the pieces live (ads, pages, or both) and watch what happens together.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold">
                    Adjust what matters
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Keep what brings real conversations; change what does not.
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
        heading="Built for businesses around Plant City, Tampa, Orlando, and Sarasota"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            We are based in Plant City and work with small businesses across Central Florida, including Tampa, Brandon, Lakeland, Wesley Chapel, Orlando, and Sarasota. Local context helps us speak your customers' language. If you are a little farther out and it is a good fit, we can still help.
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
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
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
                href="/services/content-creation"
                class="rounded-xl border border-border-default bg-white p-5 text-left transition hover:border-brand-accent/50 hover:shadow-md"
                data-test="service-related-content-creation"
            >
                <h3 class="font-semibold text-[var(--text-primary-on-light)]">
                    Content creation
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
        heading="Ready for more of the right conversations?"
        body="Tell us who you want to reach. We will help you figure out a sensible way to get in front of them, and turn interest into real inquiries."
        button="Talk about getting more leads"
        test-id="service-closing-cta"
    />
</template>
