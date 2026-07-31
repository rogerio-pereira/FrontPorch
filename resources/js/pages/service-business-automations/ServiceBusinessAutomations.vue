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
    <Head title="Business Automations for Small Businesses | Front Porch Creative">
        <meta
            name="description"
            content="Save hours every week with practical automations: follow-ups, reminders, and handoffs that run themselves for Central Florida small businesses."
        />
        <meta property="og:title" content="Let the repetitive work run itself" />
        <meta property="og:description" content="Practical automations that free your time for customers, not complicated systems you never finish setting up." />
        <meta property="og:image" content="/images/service-business-automations/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Business automations
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        Give the copy-paste work to the system, keep the human parts for yourself.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We connect the tools you already use so quotes, follow-ups, reminders, and handoffs happen without you chasing every detail. Less busywork. More time with customers.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Free up my week"
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
                        src="/images/service-business-automations/hero.png"
                        alt="Illustration of connected business tools handling routine tasks automatically"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="The quiet time drain"
        heading="You did not start a business to retype the same information"
        intro="Manual steps feel &quot;fine&quot; until they steal evenings, or a lead sits unanswered because someone forgot."
        light
        wide
    >
        <div class="grid gap-4 sm:grid-cols-2">
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    01
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Same info, three places
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Forms, spreadsheets, and inboxes that never stay in sync.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    02
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Follow-ups that depend on memory
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Good intentions, busy days, cold leads.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    03
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    Handoffs that drop
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    One person finishes a step; the next person never hears about it.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-white p-5">
                <p class="text-overline text-brand-accent">
                    04
                </p>
                <h3 class="mt-2 font-semibold text-[var(--text-primary-on-light)]">
                    "We'll automate later"
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-light)]">
                    Later never comes, and the pile keeps growing.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="What you get back"
        heading="Hours returned. Fewer dropped balls. Calmer weeks."
        intro="Automations should feel like relief, not another project that makes life more complicated."
        wide
    >
        <div class="mx-auto max-w-3xl space-y-5">
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Time back for real work
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    The tasks you do every week finally run without you.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Faster, kinder follow-up
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Interested people hear from you while interest is still warm.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Fewer mistakes
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Less retyping means fewer wrong numbers, missed emails, and awkward apologies.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Clearer handoffs
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    The next person (or the next you) knows exactly what happened.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Start with one win
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    We pick a high-pain workflow first so you feel the difference quickly.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="Before and after"
        heading="From sticky notes and late-night catch-up to a week that breathes"
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Imagine a new inquiry that lands in the right place, triggers a friendly confirmation, and reminds you to follow up, without you building the checklist from scratch every time. That is the kind of quiet upgrade we love shipping.
                </p>
            </div>
            <VisualFrame
                src="/images/service-business-automations/spotlight.png"
                alt="Side-by-side feeling of chaotic manual tasks versus a calm automated flow"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we automate"
        heading="Practical first. Fancy never required."
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold">
                    Map the friction
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Where do hours disappear? Where do leads go quiet?
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold">
                    Design the simplest flow
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Only the steps that matter, no Rube Goldberg machines.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold">
                    Connect and test
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Wire the tools, try real scenarios, fix the rough edges together.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold">
                    Hand over with confidence
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    You know what runs automatically, and what still needs a human touch.
                </p>
            </article>
        </div>
    </SectionShell>

    <CtaBand
        heading="Which task would you happily never do by hand again?"
        body="Bring that one to a discovery call. We will sketch whether a simple automation can take it off your plate."
        button="Free up my week"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="Built for owners wearing every hat"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            Small teams around Plant City, Tampa, Lakeland, Orlando, and Sarasota rarely have a "operations person." Automations are how you get some of that support without hiring a whole department, so you can keep the personal service your customers love.
        </p>
    </SectionShell>

    <SectionShell
        heading="We will not automate chaos"
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            If a process is unclear, we tidy the thinking first. Automating a mess only makes a faster mess. You will always understand what we built and why.
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
        heading="Ready for a calmer week?"
        body="Let's find the repetitive work that steals your evenings, and put it on autopilot the sensible way."
        button="Free up my week"
        test-id="service-closing-cta"
    />
</template>
