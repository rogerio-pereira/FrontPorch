<script setup lang="ts">
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';

defineProps<{
    heading: string;
    body: string;
    button: string;
    testId?: string;
    light?: boolean;
}>();
</script>

<template>
    <section
        :class="[
            light
                ? 'bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]'
                : 'bg-brand-bg text-[var(--text-on-dark)]',
            'section-y-tight relative overflow-hidden border-y',
            light ? 'border-border-default' : 'border-brand-accent/20',
        ]"
    >
        <DecorativeBackground
            v-if="!light"
            variant="both"
        />
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                :class="[
                    light
                        ? 'border-border-default bg-white'
                        : 'border-brand-accent/25 bg-surface-raised/80 backdrop-blur-sm',
                    'mx-auto flex max-w-4xl flex-col items-center gap-6 rounded-2xl border p-8 text-center lg:p-12',
                ]"
            >
                <h2
                    :class="[
                        light ? 'text-[var(--text-primary-on-light)]' : 'text-[var(--text-on-dark)]',
                        'text-h2 font-semibold',
                    ]"
                >
                    {{ heading }}
                </h2>
                <p
                    :class="[
                        light ? 'text-[var(--text-muted-on-light)]' : 'text-[var(--text-muted-on-dark)]',
                        'max-w-2xl text-body-lg',
                    ]"
                >
                    {{ body }}
                </p>
                <CtaButton
                    :label="button"
                    size="lg"
                    :test-id="testId"
                />
            </div>
        </div>
    </section>
</template>
