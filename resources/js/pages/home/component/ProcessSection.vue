<script setup lang="ts">
import SectionShell from '@/layouts/app/SectionShell.vue';

const steps = [
    {
        title: 'Discovery call',
        description: 'We learn your business, what is working, what is not, and what you want to change.',
    },
    {
        title: 'A clear plan',
        description: 'A clear proposal covering what we will do, when, and how we will know it works.',
    },
    {
        title: 'Build & launch',
        description: 'We create, connect, and launch, checking in so nothing feels like a black box.',
    },
    {
        title: 'See what works',
        description: 'We look at real numbers together and adjust when something needs a tweak.',
    },
    {
        title: 'Keep growing',
        description: 'As your business changes, we stay available to help you adapt and expand.',
    },
];
</script>

<template>
    <SectionShell
        overline="How it works"
        heading="Simple steps, no mystery"
        wide
        centered
    >
        <div class="grid gap-4 lg:grid-cols-5">
            <article
                v-for="(step, index) in steps"
                :key="step.title"
                class="marketing-card-hover relative rounded-xl border border-border-default bg-surface-raised p-5 text-center"
            >
                <div
                    class="mx-auto mb-4 flex size-12 items-center justify-center rounded-full bg-brand-accent text-lg font-bold text-brand-bg"
                >
                    {{ index + 1 }}
                </div>
                <h3 class="font-semibold">
                    {{ step.title }}
                </h3>
                <p class="mt-2 line-clamp-4 text-sm text-[var(--text-muted-on-dark)]">
                    {{ step.description }}
                </p>
            </article>
        </div>
    </SectionShell>
</template>
