<script setup lang="ts">
import {
    BarChart3,
    MonitorSmartphone,
    PhoneIncoming,
    Puzzle,
} from '@lucide/vue';
import IconBadge from '@/layouts/app/IconBadge.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

const icons = [MonitorSmartphone, PhoneIncoming, Puzzle, BarChart3];

const items = [
    {
        title: 'An outdated website',
        description: 'It looked fine years ago, but today it feels slow, hard to read on a phone, or just not you.',
    },
    {
        title: 'Leads that never show up',
        description: 'You put in the effort, but the phone stays quiet and the inbox never fills.',
    },
    {
        title: 'Too much manual work',
        description: 'Quotes, follow-ups, and little tasks pile up because nothing is connected.',
    },
    {
        title: 'Tools that do not talk',
        description: 'A website here, email there, spreadsheets everywhere, and no clear picture.',
    },
];
</script>

<template>
    <SectionShell
        overline="Sound familiar?"
        heading="Running the business is hard enough. Marketing shouldn't make it harder."
        wide
        centered
    >
        <template #background>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_bottom,rgba(114,136,123,0.08),transparent_60%)]" />
        </template>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <article
                v-for="(item, index) in items"
                :key="item.title"
                class="marketing-card-hover flex flex-col items-center rounded-xl border border-border-default bg-surface-raised p-6 text-center"
            >
                <IconBadge :icon="icons[index] ?? Puzzle" size="lg" />
                <h3 class="mt-4 font-semibold text-brand-accent">
                    {{ item.title }}
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                    {{ item.description }}
                </p>
            </article>
        </div>
    </SectionShell>
</template>
