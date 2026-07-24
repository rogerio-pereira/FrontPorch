<script setup lang="ts">
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';
</script>

<template>
    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative">
            <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 lg:grid-cols-2 lg:gap-16 lg:px-8">
                <div class="stack-loose motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-bottom-4 motion-safe:duration-700">
                    <p class="text-overline text-brand-accent">
                        Small business growth, the human way
                    </p>
                    <h1 class="text-display font-thin" data-test="home-hero-headline">
                        You do great work. Let's help more people find you.
                    </h1>
                    <p class="max-w-xl text-body-lg text-[var(--text-muted-on-dark)]">
                        We work with small business owners who want their website, marketing, and everyday tools to actually work together, so you get more visibility, more leads, and a little breathing room in your week.
                    </p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <CtaButton
                            label="Book a discovery call"
                            size="lg"
                            test-id="home-hero-primary-cta"
                        />
                        <CtaButton
                            label="Send us a message → #contact"
                            variant="outline"
                            size="lg"
                            test-id="home-hero-secondary-cta"
                        />
                    </div>
                </div>

                <div
                    class="relative motion-safe:animate-in motion-safe:fade-in motion-safe:slide-in-from-right-4 motion-safe:duration-700 motion-safe:delay-150"
                    data-test="home-hero-visual"
                >
                    <div class="absolute -inset-4 rounded-2xl bg-brand-accent/10 blur-2xl" />
                    <VisualFrame
                        src="/images/home/hero.png"
                        alt="Preview of a modern small business website and marketing dashboard"
                        aspect="portrait"
                        class="relative shadow-2xl"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
