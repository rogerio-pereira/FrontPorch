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
    testimonials: Array<{ quote: string; attribution: string }>;
}>();
</script>

<template>
    <Head title="Custom Software for Small Businesses | Front Porch Creative">
        <meta
            name="description"
            content="Custom tools when off-the-shelf software does not fit: practical software for small businesses in Central Florida who need something that matches how they work."
        />
        <meta property="og:title" content="Software that fits how you actually work" />
        <meta property="og:description" content="When ready-made tools fight your process, we build something that feels natural." />
        <meta property="og:image" content="/images/service-custom-software-development/hero.png" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Custom software development
                    </p>
                    <h1 class="text-display font-thin" data-test="service-heading">
                        When ready-made tools do not fit, we build something that does.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        Spreadsheets stretched past their limit. Three apps that almost work. Workarounds stacked on workarounds. We create focused software for small businesses who need a better fit, without enterprise complexity.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Explore a custom fit"
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
                        src="/images/service-custom-software-development/hero.png"
                        alt="Illustration of tailor-made software shaped around a small business workflow"
                        aspect="video"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>

    <SectionShell
        overline="Why custom can be the simpler path"
        heading="Built around your process, not the other way around"
        intro="The best tool is the one your team will actually use. Sometimes that means building it with intention."
        wide
    >
        <div class="mx-auto max-w-3xl space-y-5">
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Fits the way you already work
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Screens and steps that match your real day, not a generic template.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Fewer workarounds
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Less bouncing between apps and patching gaps with spreadsheets.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Clarity for your team
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    One place for the job at hand, with less training theater.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Room to evolve
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    Start with what matters most; grow the tool as the business grows.
                </p>
            </article>
            <article class="rounded-xl border border-border-default bg-surface-raised p-5 sm:p-6">
                <h3 class="font-semibold text-[var(--text-on-dark)]">
                    Honest scoping
                </h3>
                <p class="mt-2 text-body text-[var(--text-muted-on-dark)]">
                    We say when a simpler existing tool is enough, custom is not always the answer.
                </p>
            </article>
        </div>
    </SectionShell>

    <SectionShell
        overline="The right question"
        heading="Not &quot;can we build it?&quot;, but &quot;should we?&quot;"
        light
        wide
    >
        <div class="grid items-center gap-10 lg:grid-cols-2 lg:[&>*:first-child]:order-2">
            <div class="stack-default max-w-xl">
                <p class="text-body-lg text-[var(--text-muted-on-light)]">
                    Custom software is a bigger commitment than a landing page. We treat that seriously. First we dig into the pain: Is the problem a missing tool, a messy process, or both? If a lighter fix will do, we will tell you. If building is the clear win, we keep the scope focused so you get value without boiling the ocean.
                </p>
            </div>
            <VisualFrame
                src="/images/service-custom-software-development/spotlight.png"
                alt="Thoughtful illustration of choosing a tailored tool over a pile of mismatched apps"
                aspect="video"
                class="shadow-lg"
            />
        </div>
    </SectionShell>

    <SectionShell
        overline="How we build"
        heading="Small steps. Clear checkpoints. No surprise black boxes."
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    1
                </div>
                <h3 class="font-semibold">
                    Diagnose the real need
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    What hurts today, who uses it, and what "better" looks like.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    2
                </div>
                <h3 class="font-semibold">
                    Shape a focused plan
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Scope you can understand: what is in, what is out, and why.
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    3
                </div>
                <h3 class="font-semibold">
                    Build in visible slices
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    You see progress early and can steer before everything is "done."
                </p>
            </article>
            <article class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-left">
                <div class="mb-4 flex size-10 items-center justify-center rounded-full bg-brand-accent text-sm font-bold text-brand-bg">
                    4
                </div>
                <h3 class="font-semibold">
                    Launch and support
                </h3>
                <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                    Go live with training that sticks, then refine based on real use.
                </p>
            </article>
        </div>
    </SectionShell>

    <CtaBand
        heading="Fighting your tools more than using them?"
        body="Describe the friction. We will help you see whether custom software, an automation, or a simpler tweak is the right move."
        button="Explore a custom fit"
        test-id="service-mid-cta"
    />

    <SectionShell
        overline="Central Florida"
        heading="Partner-level software for local operators"
        light
        centered
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-light)]">
            We work side-by-side with owners in Plant City, Tampa, Lakeland, and nearby communities. You do not need a big IT department, you need a partner who explains options plainly and builds only what earns its keep.
        </p>
    </SectionShell>

    <SectionShell
        heading="Custom does not mean complicated"
        centered
        tight
    >
        <p class="mx-auto max-w-2xl text-center text-body-lg text-[var(--text-muted-on-dark)]">
            We aim for intentional simplicity. Fancy tech only when it serves the business. You will always know what we are building, what it costs to get there, and how we will know it is working.
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
        </div>
    </SectionShell>

    <ServiceTestimonialsSection :quotes="testimonials" />
    <ServiceFaqSection :items="faqs" />

    <CtaBand
        heading="Ready for tools that finally feel like yours?"
        body="Pull up a chair and tell us how work really happens day to day. We will help you decide what, if anything, is worth building."
        button="Explore a custom fit"
        test-id="service-closing-cta"
    />
</template>
