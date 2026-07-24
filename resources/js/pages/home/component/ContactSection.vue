<script setup lang="ts">
import { Mail } from '@lucide/vue';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

const contactEmail = 'contact@example.com';

const paragraphs = [
    'Share a little about your business and what you are hoping to improve. We usually reply within one business day.',
    'Want to talk live? Book a discovery call and we will walk through your goals together. We will confirm timing and format when you schedule.',
];
</script>

<template>
    <SectionShell
        id="contact"
        overline="Contact"
        heading="We would love to hear from you"
        light
        wide
    >
        <template #background>
            <DecorativeBackground variant="grid" />
        </template>

        <div class="mx-auto max-w-2xl stack-loose rounded-xl border border-border-default bg-white p-8 text-center lg:p-10">
            <p
                v-for="(paragraph, index) in paragraphs"
                :key="index"
                class="text-body-lg text-[var(--text-muted-on-light)]"
            >
                {{ paragraph }}
            </p>
            <div class="flex items-center justify-center gap-3 text-sm text-[var(--text-primary-on-light)]">
                <Mail class="size-5 text-brand-accent" />
                <a
                    :href="`mailto:${contactEmail}`"
                    class="font-semibold text-brand-accent hover:underline"
                    data-test="home-contact-email"
                >
                    {{ contactEmail }}
                </a>
            </div>
            <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                <CtaButton
                    label="Book a discovery call"
                    test-id="home-contact-schedule"
                />
                <a
                    :href="`mailto:${contactEmail}`"
                    class="text-sm font-semibold text-brand-accent hover:underline"
                    data-test="home-contact-email-cta"
                >
                    Or email us directly
                </a>
            </div>
        </div>
    </SectionShell>
</template>
