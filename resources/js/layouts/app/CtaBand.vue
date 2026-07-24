<script setup lang="ts">
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';

defineProps<{
    heading: string;
    body: string;
    button: string;
    calendarUrl?: string;
    testId?: string;
}>();
</script>

<template>
    <section class="section-y-tight relative overflow-hidden border-y border-brand-accent/20">
        <DecorativeBackground variant="both" />
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto flex max-w-4xl flex-col items-center gap-6 rounded-2xl border border-brand-accent/25 bg-surface-raised/80 p-8 text-center backdrop-blur-sm lg:p-12">
                <h2 class="text-h2 font-semibold text-[var(--text-on-dark)]">
                    {{ heading }}
                </h2>
                <p class="max-w-2xl text-body-lg text-[var(--text-muted-on-dark)]">
                    {{ body }}
                </p>
                <CtaButton
                    :label="button"
                    :calendar-url="calendarUrl"
                    size="lg"
                    :test-id="testId"
                />
            </div>
        </div>
    </section>
</template>
