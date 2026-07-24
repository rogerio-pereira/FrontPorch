<script setup lang="ts">
import {
    BarChart3,
    MonitorSmartphone,
    PhoneIncoming,
    Puzzle,
} from '@lucide/vue';
import IconBadge from '@/layouts/app/IconBadge.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
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
            <article class="marketing-card-hover flex flex-col items-center rounded-xl border border-border-default bg-surface-raised p-6 text-center">
                <IconBadge :icon="MonitorSmartphone" size="lg" />
                <h3 class="mt-4 font-semibold text-brand-accent">
                    An outdated website
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                    It looked fine years ago, but today it feels slow, hard to read on a phone, or just not you.
                </p>
            </article>
            <article class="marketing-card-hover flex flex-col items-center rounded-xl border border-border-default bg-surface-raised p-6 text-center">
                <IconBadge :icon="PhoneIncoming" size="lg" />
                <h3 class="mt-4 font-semibold text-brand-accent">
                    Leads that never show up
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                    You put in the effort, but the phone stays quiet and the inbox never fills.
                </p>
            </article>
            <article class="marketing-card-hover flex flex-col items-center rounded-xl border border-border-default bg-surface-raised p-6 text-center">
                <IconBadge :icon="Puzzle" size="lg" />
                <h3 class="mt-4 font-semibold text-brand-accent">
                    Too much manual work
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                    Quotes, follow-ups, and little tasks pile up because nothing is connected.
                </p>
            </article>
            <article class="marketing-card-hover flex flex-col items-center rounded-xl border border-border-default bg-surface-raised p-6 text-center">
                <IconBadge :icon="BarChart3" size="lg" />
                <h3 class="mt-4 font-semibold text-brand-accent">
                    Tools that do not talk
                </h3>
                <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                    A website here, email there, spreadsheets everywhere, and no clear picture.
                </p>
            </article>
        </div>
    </SectionShell>
</template>
