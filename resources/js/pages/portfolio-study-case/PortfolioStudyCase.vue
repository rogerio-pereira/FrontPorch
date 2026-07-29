<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import StudyCaseImageCarousel from '@/pages/portfolio-study-case/component/StudyCaseImageCarousel.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

defineProps<{
    caseStudy: {
        title: string;
        description: string;
        client: string;
        industry: string;
        service: string;
        coverImage: string;
        coverAlt: string;
        challenge: string;
        content: string;
        galleryImages: Array<{ src: string; alt: string }>;
    };
}>();
</script>

<template>
    <Head :title="`${caseStudy.title} | Portfolio | Front Porch Creative`" />

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="glow" />
        <div class="section-y relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <Link
                href="/portfolio"
                class="inline-flex text-sm font-semibold text-brand-accent hover:underline"
                data-test="study-case-back"
            >
                Back to portfolio
            </Link>

            <div class="mt-8 grid items-end gap-10 lg:grid-cols-2">
                <div class="stack-loose">
                    <p class="text-overline text-brand-accent">
                        Case study
                    </p>
                    <h1 class="text-h1 font-semibold" data-test="study-case-heading">
                        {{ caseStudy.title }}
                    </h1>
                    <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                        {{ caseStudy.description }}
                    </p>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-[var(--text-subtle-on-dark)]">
                                Client
                            </dt>
                            <dd class="mt-1 font-semibold">
                                {{ caseStudy.client }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-wide text-[var(--text-subtle-on-dark)]">
                                Industry
                            </dt>
                            <dd class="mt-1 font-semibold">
                                {{ caseStudy.industry }}
                            </dd>
                        </div>
                        <div
                            class="sm:col-span-2"
                            data-test="study-case-services"
                        >
                            <dt class="text-xs uppercase tracking-wide text-[var(--text-subtle-on-dark)]">
                                Services
                            </dt>
                            <dd class="mt-1 font-semibold">
                                {{ caseStudy.service }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <VisualFrame
                    :src="caseStudy.coverImage"
                    :alt="caseStudy.coverAlt"
                    aspect="video"
                />
            </div>
        </div>
    </section>

    <section
        class="bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]"
        data-test="study-case-challenge"
    >
        <div class="section-y mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-h2 font-semibold">
                The challenge
            </h2>
            <p class="mt-4 text-body-lg text-[var(--text-muted-on-light)] whitespace-pre-line">
                {{ caseStudy.challenge }}
            </p>
        </div>
    </section>

    <section
        class="bg-brand-bg text-[var(--text-on-dark)]"
        data-test="study-case-solution"
    >
        <div class="section-y mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-h2 font-semibold text-center">
                What we built together
            </h2>

            <div
                v-if="caseStudy.galleryImages.length > 0"
                class="mt-8"
            >
                <StudyCaseImageCarousel :images="caseStudy.galleryImages" />
            </div>

            <div
                class="prose prose-lg mx-auto mt-8 max-w-3xl text-[var(--text-muted-on-dark)] prose-headings:text-[var(--text-on-dark)] prose-a:text-brand-accent"
                data-test="study-case-content"
                v-html="caseStudy.content"
            />
        </div>
    </section>

    <section
        class="bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]"
        data-test="study-case-closing"
    >
        <div class="section-y mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-h2 font-semibold">
                A calmer way to grow
            </h2>
            <div
                class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row"
                data-test="study-case-cta"
            >
                <CtaButton
                    label="Book a discovery call"
                    test-id="study-case-schedule"
                />
                <Link
                    href="/#contact"
                    class="inline-flex items-center text-sm font-semibold text-brand-accent hover:underline"
                    data-test="study-case-contact"
                >
                    Send a message
                </Link>
            </div>
        </div>
    </section>
</template>
